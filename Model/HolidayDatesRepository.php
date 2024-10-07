<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Model;

use Exception;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Psr\Log\LoggerInterface;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;
use SelectCo\HolidayDates\Api\HolidayDatesRepositoryInterface;
use SelectCo\HolidayDates\Model\ResourceModel\HolidayDatesModel\Collection;
use SelectCo\HolidayDates\Model\ResourceModel\HolidayDatesModel\CollectionFactory;
use SelectCo\HolidayDates\Model\ResourceModel\HolidayDatesResource;

class HolidayDatesRepository implements HolidayDatesRepositoryInterface
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var HolidayDatesFactory
     */
    private $modelFactory;

    /**
     * @var HolidayDatesResource
     */
    private $resource;
    /**
     * @var CollectionFactory
     */
    private $holidayCollection;

    /**
     * @param LoggerInterface $logger
     * @param HolidayDatesFactory $modelFactory
     * @param HolidayDatesResource $resource
     * @param CollectionFactory $holidayCollection
     */
    public function __construct(
        LoggerInterface              $logger,
        HolidayDatesFactory $modelFactory,
        HolidayDatesResource     $resource,
        CollectionFactory $holidayCollection
    ) {
        $this->logger = $logger;
        $this->modelFactory = $modelFactory;
        $this->resource = $resource;
        $this->holidayCollection = $holidayCollection;
    }

    /**
     * @param HolidayDatesInterface $holidayDates
     * @return int
     * @throws CouldNotSaveException
     */
    public function save(HolidayDatesInterface $holidayDates): int
    {
        try {
            /** @var HolidayDates $model */
            $model = $this->modelFactory->create();
            $model->addData($holidayDates->getData());
            $model->setHasDataChanges(true);

            if (!$model->getData(HolidayDatesInterface::HOLIDAY_DATES_ID)) {
                $model->isObjectNew(true);
            }
            $this->resource->save($model);
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not save Holiday Date. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotSaveException(__('Could not save Holiday Date.'));
        }

        return (int)$model->getData(HolidayDatesInterface::HOLIDAY_DATES_ID);
    }

    /**
     * @param HolidayDatesInterface $holidayDates
     * @return HolidayDatesInterface
     * @throws CouldNotSaveException
     * @throws NoSuchEntityException
     */
    public function saveGet(HolidayDatesInterface $holidayDates): HolidayDatesInterface
    {
        $id = $this->save($holidayDates);
        return $this->get($id);
    }

    /**
     * @param $holidayId
     * @return HolidayDatesInterface
     * @throws NoSuchEntityException
     */
    public function get($holidayId): HolidayDatesInterface
    {
        $model = $this->modelFactory->create();
        $this->resource->load($model, $holidayId, HolidayDatesInterface::HOLIDAY_DATES_ID);

        if (!$model->getData(HolidayDatesInterface::HOLIDAY_DATES_ID)) {
            throw new NoSuchEntityException(
                __(
                    'Could not find Holiday Date with id: `%id`',
                    [
                        'id' => $holidayId
                    ]
                )
            );
        }

        return $model;
    }

    /**
     * @param HolidayDatesInterface $holidayDates
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(HolidayDatesInterface $holidayDates): bool
    {
        try {
            $this->resource->delete($holidayDates);
            return true;
        } catch (Exception $exception) {
            $this->logger->error(
                __('Could not delete Holiday Date. Original message: {message}'),
                [
                    'message' => $exception->getMessage(),
                    'exception' => $exception
                ]
            );
            throw new CouldNotDeleteException(__('Could not delete Holiday Date.'));
        }
    }

    /**
     * @param int $holidayId
     * @return bool
     * @throws CouldNotDeleteException|NoSuchEntityException
     */
    public function deleteById(int $holidayId): bool
    {
        return $this->delete($this->get($holidayId));
    }

    /**
     * @param string $column
     * @param string $value
     * @return HolidayDatesInterface|null
     */
    public function getItemByColumnValue(string $column, string $value): ?HolidayDatesInterface
    {
        /** @var Collection $holidayCollection */
        $holidayCollection = $this->holidayCollection->create();

        return $holidayCollection->getItemByColumnValue($column, $value);
    }

    /**
     * @return HolidayDatesInterface[]
     */
    public function getAll(): array
    {
        /** @var Collection $holidayCollection */
        $holidayCollection = $this->holidayCollection->create();
        return $holidayCollection->getItems();
    }

    /**
     * @return Collection
     */
    public function getCollection(): Collection
    {
        /** @var Collection $holidayCollection */
        return $this->holidayCollection->create();
    }
}