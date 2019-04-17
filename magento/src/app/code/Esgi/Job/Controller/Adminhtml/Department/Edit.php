<?php

declare(strict_types=1);

namespace Esgi\Job\Controller\Adminhtml\Department;

use Esgi\Job\Api\Data\DepartmentInterfaceFactory;
use Esgi\Job\Api\DepartmentRepositoryInterface;
use Esgi\Job\Controller\Adminhtml\Department;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Department
{
    protected $resultPageFactory;
    private $departmentRepository;
    private $departmentFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        DepartmentRepositoryInterface $departmentRepository,
        DepartmentInterfaceFactory $departmentFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->departmentRepository = $departmentRepository;
        $this->departmentFactory = $departmentFactory;

        parent::__construct($context, $coreRegistry);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');

        $model = $this->departmentFactory->create();
        if ($id) {
            $model = $this->departmentRepository->getById($id);
        }

        $this->_coreRegistry->register('job_department', $model);

        $resultPage = $this->resultPageFactory->create();

        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Department') : __('New Department'),
            $id ? __('Edit Department') : __('New Department')
        );

        $resultPage->getConfig()->getTitle()->prepend(__('Departments'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Department'));

        return $resultPage;
    }
}