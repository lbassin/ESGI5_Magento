<?php

declare(strict_types=1);

namespace Esgi\Job\Controller\Adminhtml\Department;

use Esgi\Job\Api\DepartmentRepositoryInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;

class Delete extends \Esgi\Job\Controller\Adminhtml\Department
{
    private $departmentRepository;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DepartmentRepositoryInterface $departmentRepository
    ) {
        parent::__construct($context, $coreRegistry);

        $this->departmentRepository = $departmentRepository;
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();

        $id = $this->getRequest()->getParam('id');
        if (!$id) {
            $this->messageManager->addError(__('We can\'t find a department to delete.'));

            return $resultRedirect->setPath('*/*/');
        }

        try {
            $this->departmentRepository->deleteById($id);
            $this->messageManager->addSuccess(__('You deleted the department.'));

            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());

            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }

    }
}
