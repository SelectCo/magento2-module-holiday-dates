<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Controller\Adminhtml\HolidayDates;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\DataObject;
use Magento\Framework\Exception\CouldNotSaveException;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterfaceFactory;
use SelectCo\HolidayDates\Model\HolidayDatesRepository;

/**
 * Save HolidayDates controller action.
 */
class Save extends Action implements HttpPostActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'SelectCo_HolidayDates::management';

    /**
     * @var DataPersistorInterface
     */
    private $dataPersistor;

    /**
     * @var HolidayDatesRepository
     */
    private $datesRepository;

    /**
     * @var HolidayDatesInterfaceFactory
     */
    private $entityDataFactory;

    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param HolidayDatesRepository $datesRepository
     * @param HolidayDatesInterfaceFactory $entityDataFactory
     */
    public function __construct(
        Context                      $context,
        DataPersistorInterface       $dataPersistor,
        HolidayDatesRepository       $datesRepository,
        HolidayDatesInterfaceFactory $entityDataFactory
    )
    {
        parent::__construct($context);
        $this->dataPersistor = $dataPersistor;
        $this->datesRepository = $datesRepository;
        $this->entityDataFactory = $entityDataFactory;
    }

    /**
     * Save HolidayDates Action.
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $params = $this->getRequest()->getParams();

        try {
            /** @var HolidayDatesInterface|DataObject $entityModel */
            $entityModel = $this->entityDataFactory->create();
            $entityModel->addData($params['general']);
            $this->datesRepository->save($entityModel);
            $this->messageManager->addSuccessMessage(
                __('The Holiday Dates data was saved successfully')
            );
            $this->dataPersistor->clear('entity');
        } catch (CouldNotSaveException $exception) {
            $this->messageManager->addErrorMessage($exception->getMessage());
            $this->dataPersistor->set('entity', $params);

            return $resultRedirect->setPath('*/*/edit', [
                HolidayDatesInterface::HOLIDAY_DATES_ID => $this->getRequest()->getParam(HolidayDatesInterface::HOLIDAY_DATES_ID)
            ]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
