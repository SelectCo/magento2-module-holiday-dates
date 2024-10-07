<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Api;

use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;

interface HolidayDatesRepositoryInterface
{
    /**
     * @param HolidayDatesInterface $holidayDates
     * @return int
     */
    public function save(HolidayDatesInterface $holidayDates): int;

    /**
     * @param HolidayDatesInterface $holidayDates
     * @return HolidayDatesInterface
     */
    public function saveGet(HolidayDatesInterface $holidayDates): HolidayDatesInterface;

    /**
     * @param $holidayId
     * @return HolidayDatesInterface
     */
    public function get($holidayId): HolidayDatesInterface;

    /**
     * @param HolidayDatesInterface $holidayDates
     * @return bool
     */
    public function delete(HolidayDatesInterface $holidayDates): bool;

    /**
     * @param int $holidayId
     * @return bool
     */
    public function deleteById(int $holidayId): bool;
}