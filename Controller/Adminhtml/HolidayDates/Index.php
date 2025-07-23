<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Controller\Adminhtml\HolidayDates;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * HolidayDates backend index (list) controller.
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session.
     */
    public const ADMIN_RESOURCE = 'SelectCo_HolidayDates::management';

    /**
     * Execute action based on request and return result.
     *
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        $resultPage->setActiveMenu('SelectCo_HolidayDates::management');
        $resultPage->addBreadcrumb(__('HolidayDates'), __('HolidayDates'));
        $resultPage->addBreadcrumb(__('Manage HolidayDates'), __('Manage Holiday Dates'));
        $resultPage->getConfig()->getTitle()->prepend(__('HolidayDates List'));

        return $resultPage;
    }
}
