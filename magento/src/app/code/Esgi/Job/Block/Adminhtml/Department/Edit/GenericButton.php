<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Esgi\Job\Block\Adminhtml\Department\Edit;

use Esgi\Job\Api\DepartmentRepositoryInterface;
use Magento\Backend\Block\Widget\Context;
use Magento\Framework\Exception\NoSuchEntityException;

class GenericButton
{
    protected $context;

    protected $departmentRepository;

    public function __construct(Context $context, DepartmentRepositoryInterface $departmentRepository)
    {
        $this->context = $context;
        $this->departmentRepository = $departmentRepository;
    }

    public function getDepartmentId()
    {
        try {
            return $this->departmentRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {

        }

        return null;
    }

    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
