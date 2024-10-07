<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Model;

use Magento\Framework\Model\AbstractModel;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;
use SelectCo\HolidayDates\Model\ResourceModel\HolidayDatesResource;

class HolidayDates extends AbstractModel implements HolidayDatesInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'selectco_holiday_dates_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(HolidayDatesResource::class);
    }

    /**
     * @inheritDoc
     */
    public function getHolidayDatesId(): ?int
    {
        if ($this->getData(self::HOLIDAY_DATES_ID) === null) {
            return null;
        }
        return (int)$this->getData(self::HOLIDAY_DATES_ID);
    }

    /**
     * @inheritDoc
     */
    public function setHolidayDatesId(?int $holidayDatesId): void
    {
        $this->setData(self::HOLIDAY_DATES_ID, $holidayDatesId);
    }

    /**
     * @inheritDoc
     */
    public function getDate(): ?string
    {
        if ($this->getData(self::DATE) === null) {
            return null;
        }
        return $this->getData(self::DATE);
    }

    /**
     * @inheritDoc
     */
    public function setDate(?string $date): void
    {
        $this->setData(self::DATE, $date);
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        if ($this->getData(self::NAME) === null) {
            return null;
        }
        return $this->getData(self::NAME);
    }

    /**
     * @inheritDoc
     */
    public function setName(?string $name): void
    {
        $this->setData(self::NAME, $name);
    }
}
