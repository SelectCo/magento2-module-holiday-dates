<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;

class HolidayDatesResource extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'selectco_holiday_dates_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('selectco_holiday_dates', HolidayDatesInterface::HOLIDAY_DATES_ID);
        $this->_useIsObjectNew = true;
    }
}
