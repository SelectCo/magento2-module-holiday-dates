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
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use SelectCo\HolidayDates\Helper\Data;
use SelectCo\HolidayDates\Model\HolidayDatesRepository;

class PurgeDates
{
    /**
     * @var Data
     */
    private $helper;
    /**
     * @var HolidayDatesRepository
     */
    private $datesRepository;

    public function __construct(Data $helper, HolidayDatesRepository $datesRepository)
    {
        $this->helper = $helper;
        $this->datesRepository = $datesRepository;
    }

    /**
     * @param bool|null $all
     * @return void
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     * @throws Exception
     */
    public function execute(?bool $all = false)
    {
        if (!$this->helper->isModuleEnabled()) {
            return;
        }

        if ($all) {
            $holidayDates = $this->datesRepository->getAll();
        } else {
            $monthsHistory = $this->helper->getMonthsHistory();
            if (!is_numeric($monthsHistory))
            {
                return;
            }

            $dateNow = new DateTime('now');
            $dateNow->sub(new DateInterval('P' . (int)$monthsHistory . 'M'));
            $holidayDates = $this->datesRepository->getCollection();
            $holidayDates->addFieldToFilter('date', ['lt' => $dateNow->format('Y-m-d')]);
            $holidayDates->getItems();
        }

        if (count($holidayDates) < 1) {
            return;
        }

        foreach ($holidayDates as $date) {
            $this->datesRepository->deleteById($date->getHolidayDatesId());
        }
    }
}