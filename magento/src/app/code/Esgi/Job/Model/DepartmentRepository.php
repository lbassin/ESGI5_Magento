<?php

declare(strict_types=1);

namespace Esgi\Job\Model;

use Esgi\Job\Api\Data;
use Esgi\Job\Api\Data\DepartmentInterface;
use Esgi\Job\Api\Data\DepartmentInterfaceFactory;
use Esgi\Job\Api\Data\DepartmentSearchResultsInterfaceFactory;
use Esgi\Job\Api\DepartmentRepositoryInterface;
use Esgi\Job\Model\ResourceModel\Department as DepartmentResource;
use Esgi\Job\Model\ResourceModel\Department\CollectionFactory as DepartmentCollectionFactory;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    protected $resource;
    protected $departmentFactory;
    protected $departmentCollectionFactory;
    protected $searchResultsFactory;

    public function __construct(
        DepartmentResource $resource,
        DepartmentInterfaceFactory $departmentFactory,
        DepartmentCollectionFactory $departmentCollectionFactory,
        DepartmentSearchResultsInterfaceFactory $searchResultsFactory
    ) {
        $this->resource = $resource;
        $this->departmentFactory = $departmentFactory;
        $this->departmentCollectionFactory = $departmentCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    public function save(DepartmentInterface $department): DepartmentInterface
    {
        try {
            $this->resource->save($department);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $department;
    }

    public function getById($departmentId): DepartmentInterface
    {
        $department = $this->departmentFactory->create();
        $this->resource->load($department, $departmentId);
        if (!$department->getId()) {
            throw new NoSuchEntityException(__('Department with id "%1" does not exist.', $department));
        }

        return $department;
    }

    public function getList(SearchCriteriaInterface $criteria): Data\DepartmentSearchResultsInterface
    {
        $collection = $this->departmentCollectionFactory->create();

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    public function delete(DepartmentInterface $department): void
    {
        try {
            $this->resource->delete($department);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
    }

    public function deleteById($departmentId): void
    {
        $this->delete($this->getById($departmentId));
    }
}
