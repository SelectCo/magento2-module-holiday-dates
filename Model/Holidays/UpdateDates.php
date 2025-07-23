<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Model\Holidays;

use DateInterval;
use DateTime;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Magento\Framework\Exception\CouldNotSaveException;
use SelectCo\HolidayDates\Helper\Data;
use SelectCo\HolidayDates\Model\HolidayDatesFactory;
use SelectCo\HolidayDates\Model\HolidayDatesRepository;

class UpdateDates
{
    /**
     * @var Data
     */
    private $helper;
    /**
     * @var HolidayDatesFactory
     */
    private $modelFactory;
    /**
     * @var HolidayDatesRepository
     */
    private $datesRepository;

    public function __construct(Data $helper, HolidayDatesFactory $modelFactory, HolidayDatesRepository $datesRepository)
    {
        $this->helper = $helper;
        $this->modelFactory = $modelFactory;
        $this->datesRepository = $datesRepository;
    }

    /**
     * @throws Exception
     */
    public function execute()
    {
        if (!$this->helper->isModuleEnabled()) {
            return;
        }

        $futureDate = $this->helper->getYears();
        if (!is_numeric($futureDate)) {
            return;
        }
        $currentYear = 0;

        do {
            $client = new Client();
            $year = new DateTime('now');
            $year->add(new DateInterval('P' . $currentYear . 'Y'));

            $apiUrl = $this->helper->getApiUrl();
            $countryCode = $this->helper->getCountryCode();
            $subCountryCode = $this->helper->getSubCountryCode();

            if(substr($apiUrl , -1) != '/'){
                $apiUrl = $apiUrl . '/';
            }

            try {
                $response = $client->request('GET', "{$apiUrl}{$year->format('Y')}/{$countryCode}");
            } catch (GuzzleException $e) {
                return;
            }

            if ($response->getStatusCode() != 200) {
                return;
            }

            $json = $response->getBody()->getContents();
            foreach (json_decode($json, true) as $date) {
                if (!array_key_exists('date', $date) || $date['date'] == null) {
                    continue;
                }
                if (!array_key_exists('name', $date) || $date['name'] == null) {
                    continue;
                }
                if (array_key_exists('counties', $date) && $date['counties'] != null && is_array($date['counties'])) {
                    $countryCheck = false;
                    foreach ($date['counties'] as $country) {
                        if ($countryCode . '-' . $subCountryCode == $country) {
                            $countryCheck = true;
                        }
                    }

                    if ($countryCheck === false) {
                        continue;
                    }
                }
                if ($this->datesRepository->getItemByColumnValue('date', $date['date'])) {
                    continue;
                }

                $model = $this->modelFactory->create();
                $model->setDate($date['date']);
                $model->setName($date['name']);

                try {
                    $this->datesRepository->save($model);
                } catch (CouldNotSaveException $e) {
                }
            }
            $currentYear++;
        } while ($currentYear <= (int)$futureDate);
    }
}
