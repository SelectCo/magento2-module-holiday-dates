<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace SelectCo\HolidayDates\Mapper;

use Magento\Framework\DataObject;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterface;
use SelectCo\HolidayDates\Api\Data\HolidayDatesInterfaceFactory;
use SelectCo\HolidayDates\Model\HolidayDates;

/**
 * Converts a collection of HolidayDate entities to an array of data transfer objects.
 */
class HolidayDatesDataMapper
{
    /**
     * @var HolidayDatesInterfaceFactory
     */
    private $entityDtoFactory;

    /**
     * @param HolidayDatesInterfaceFactory $entityDtoFactory
     */
    public function __construct(
        HolidayDatesInterfaceFactory $entityDtoFactory
    )
    {
        $this->entityDtoFactory = $entityDtoFactory;
    }

    /**
     * Map magento models to DTO array.
     *
     * @param AbstractCollection $collection
     *
     * @return array|HolidayDatesInterface[]
     */
    public function map(AbstractCollection $collection): array
    {
        $results = [];
        /** @var HolidayDates $item */
        foreach ($collection->getItems() as $item) {
            /** @var HolidayDatesInterface|DataObject $entityDto */
            $entityDto = $this->entityDtoFactory->create();
            $entityDto->addData($item->getData());

            $results[] = $entityDto;
        }

        return $results;
    }
}
