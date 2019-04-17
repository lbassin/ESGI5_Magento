<?php

declare(strict_types=1);

namespace Esgi\Job\Api;

/**
 * Esgi job CRUD interface.
 * @api
 */
interface DepartmentRepositoryInterface
{
    /**
     * Save block.
     *
     * @param \Esgi\Job\Api\Data\DepartmentInterface $department
     *
     * @return \Esgi\Job\Api\Data\DepartmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(Data\DepartmentInterface $department);

    /**
     * Retrieve $department.
     *
     * @param int $departmentId
     *
     * @return \Esgi\Job\Api\Data\DepartmentInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($departmentId);

    /**
     * Retrieve departments matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     *
     * @return \Esgi\Job\Api\Data\DepartmentSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete department.
     *
     * @param \Esgi\Job\Api\Data\DepartmentInterface $department
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(Data\DepartmentInterface $department);

    /**
     * Delete department by ID.
     *
     * @param int $departmentId
     *
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($departmentId);
}