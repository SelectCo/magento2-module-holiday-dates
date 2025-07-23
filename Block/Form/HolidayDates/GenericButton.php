<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Block\Form\HolidayDates;

use Magento\Backend\Block\Widget\Context;
use Magento\Framework\UrlInterface;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;

/**
 * Generic (form) button for HolidayDates entity.
 */
class GenericButton
{
    /**
     * @var Context
     */
    private $context;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    )
    {
        $this->context = $context;
        $this->urlBuilder = $context->getUrlBuilder();
    }

    /**
     * Get HolidayDates entity id.
     *
     * @return int
     */
    public function getHolidayDatesId(): int
    {
        return (int)$this->context->getRequest()->getParam(HolidayDatesInterface::HOLIDAY_DATES_ID);
    }

    /**
     * Wrap button specific options to settings array.
     *
     * @param string $label
     * @param string $class
     * @param string|null $onclick
     * @param array|null $dataAttribute
     * @param int $sortOrder
     *
     * @return array
     */
    protected function wrapButtonSettings(
        string $label,
        string $class,
        ?string $onclick = null,
        ?array  $dataAttribute = null,
        int    $sortOrder = 0
    ): array
    {
        $dataAttribute = $dataAttribute ?? [];
        $onclick = $onclick ?? '';
        return [
            'label' => $label,
            'on_click' => $onclick,
            'data_attribute' => $dataAttribute,
            'class' => $class,
            'sort_order' => $sortOrder
        ];
    }

    /**
     * Get url.
     *
     * @param string $route
     * @param array $params
     *
     * @return string
     */
    protected function getUrl(string $route, array $params = []): string
    {
        return $this->urlBuilder->getUrl($route, $params);
    }
}
