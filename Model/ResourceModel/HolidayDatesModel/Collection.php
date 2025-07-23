<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Model\ResourceModel\HolidayDatesModel;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SelectCo\HolidayDates\Model\HolidayDates;
use SelectCo\HolidayDates\Model\ResourceModel\HolidayDatesResource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'selectco_holiday_dates_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(HolidayDates::class, HolidayDatesResource::class);
    }
}
