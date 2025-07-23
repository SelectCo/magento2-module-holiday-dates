<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Controller\Adminhtml\HolidayDates;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;
use SelectCo\HolidayDates\Model\HolidayDatesRepository;

/**
 * Delete HolidayDates controller.
 */
class Delete extends Action implements HttpPostActionInterface, HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session.
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'SelectCo_HolidayDates::management';

    /**
     * @var HolidayDatesRepository
     */
    private $datesRepository;


    /**
     * @param Context $context
     * @param HolidayDatesRepository $datesRepository
     */
    public function __construct(
        Context           $context,
        HolidayDatesRepository $datesRepository
    )
    {
        parent::__construct($context);
        $this->datesRepository = $datesRepository;
    }

    /**
     * Delete HolidayDates action.
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var ResultInterface $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $resultRedirect->setPath('*/*/');
        $entityId = (int)$this->getRequest()->getParam(HolidayDatesInterface::HOLIDAY_DATES_ID);

        try {
            $this->datesRepository->deleteById($entityId);
            $this->messageManager->addSuccessMessage(__('You have successfully deleted Holiday Dates entity'));
        } catch (CouldNotDeleteException|NoSuchEntityException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
        }

        return $resultRedirect;
    }
}
