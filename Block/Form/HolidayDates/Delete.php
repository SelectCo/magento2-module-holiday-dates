<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Block\Form\HolidayDates;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;

/**
 * Delete entity button.
 */
class Delete extends GenericButton implements ButtonProviderInterface
{
    /**
     * Retrieve Delete button settings.
     *
     * @return array
     */
    public function getButtonData(): array
    {
        if (!$this->getHolidayDatesId()) {
            return [];
        }

        return $this->wrapButtonSettings(
            __('Delete')->getText(),
            'delete',
            sprintf("deleteConfirm('%s', '%s')",
                __('Are you sure you want to delete this holiday date?'),
                $this->getUrl(
                    '*/*/delete',
                    [HolidayDatesInterface::HOLIDAY_DATES_ID => $this->getHolidayDatesId()]
                )
            ),
            [],
            20
        );
    }
}
