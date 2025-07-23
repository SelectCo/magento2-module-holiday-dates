<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use SelectCo\Core\Helper\Data as CoreHelperData;
use SelectCo\HolidayDates\Model\HolidayDatesRepository;

class Data extends AbstractHelper
{
    const HOLIDAY_DATES_ENABLED = 'selectco_hd/general/enabled';
    const HOLIDAY_DATES_API_URL = 'selectco_hd/general/api_url';
    const HOLIDAY_DATES_COUNTRY_CODE = 'selectco_hd/general/country_code';
    const HOLIDAY_DATES_SUB_COUNTRY_CODE = 'selectco_hd/general/sub_country_code';
    const HOLIDAY_DATES_YEARS = 'selectco_hd/general/years';
    const HOLIDAY_DATES_MONTHS_HISTORY = 'selectco_hd/general/months_history';

    /**
     * @var CoreHelperData
     */
    private $coreHelper;

    /**
     * @var HolidayDatesRepository
     */
    private $datesRepository;

    /**
     * @param Context $context
     * @param CoreHelperData $coreHelper
     * @param HolidayDatesRepository $datesRepository
     */
    public function __construct(Context $context, CoreHelperData $coreHelper, HolidayDatesRepository $datesRepository)
    {
        parent::__construct($context);
        $this->coreHelper = $coreHelper;
        $this->datesRepository = $datesRepository;
    }

    /**
     * @param string $field
     * @return mixed
     */
    private function getConfigValue(string $field)
    {
        return $this->coreHelper->getConfigValue($field);
    }

    /**
     * @return bool
     */
    public function isModuleEnabled(): bool
    {
        return (bool) $this->getConfigValue(self::HOLIDAY_DATES_ENABLED);
    }

    /**
     * @return string|null
     */
    public function getApiUrl(): ?string
    {
        return $this->getConfigValue(self::HOLIDAY_DATES_API_URL);
    }

    /**
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->getConfigValue(self::HOLIDAY_DATES_COUNTRY_CODE);
    }

    /**
     * @return string|null
     */
    public function getSubCountryCode(): ?string
    {
        return $this->getConfigValue(self::HOLIDAY_DATES_SUB_COUNTRY_CODE);
    }

    /**
     * @return string|null
     */
    public function getYears(): ?string
    {
        return $this->getConfigValue(self::HOLIDAY_DATES_YEARS);
    }

    /**
     * @return string|null
     */
    public function getMonthsHistory(): ?string
    {
        return $this->getConfigValue(self::HOLIDAY_DATES_MONTHS_HISTORY);
    }

    /**
     * @return array
     */
    public function getHolidayDates(): array
    {
        $holidays = $this->datesRepository->getAll();
        $dates = [];
        foreach ($holidays as $holiday) {
            $dates[] = $holiday->getDate();
        }

        return $dates;
    }
}
