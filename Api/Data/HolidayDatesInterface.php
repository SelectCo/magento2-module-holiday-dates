<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Api\Data;

interface HolidayDatesInterface
{
    /**
     * String constants for property names
     */
    public const HOLIDAY_DATES_ID = "holiday_dates_id";
    public const DATE = "date";
    public const NAME = "name";

    /**
     * Getter for HolidayDatesId.
     *
     * @return int|null
     */
    public function getHolidayDatesId(): ?int;

    /**
     * Setter for HolidayDatesId.
     *
     * @param int|null $holidayDatesId
     *
     * @return void
     */
    public function setHolidayDatesId(?int $holidayDatesId): void;

    /**
     * Getter for Date.
     *
     * @return string|null
     */
    public function getDate(): ?string;

    /**
     * Setter for Date.
     *
     * @param string|null $date
     *
     * @return void
     */
    public function setDate(?string $date): void;

    /**
     * Getter for Name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Setter for Name.
     *
     * @param string|null $name
     *
     * @return void
     */
    public function setName(?string $name): void;
}
