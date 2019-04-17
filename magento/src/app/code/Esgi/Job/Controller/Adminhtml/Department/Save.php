<?php

namespace Esgi\Job\Controller\Adminhtml\Department;

use Esgi\Job\Api\Data\DepartmentInterfaceFactory;
use Esgi\Job\Api\DepartmentRepositoryInterface;
use Esgi\Job\Model\Department;
use Esgi\Job\Model\ResourceModel\Department as DepartmentResourceModel;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;

class Save extends \Esgi\Job\Controller\Adminhtml\Department
{
    protected $dataPersistor;
    protected $departmentRepository;
    protected $departmentFactory;
    protected $departmentResourceModel;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        DepartmentRepositoryInterface $departmentRepository,
        DepartmentInterfaceFactory $departmentFactory,
        DepartmentResourceModel $departmentResourceModel
    ) {
        parent::__construct($context, $coreRegistry);

        $this->dataPersistor = $dataPersistor;
        $this->departmentRepository = $departmentRepository;
        $this->departmentFactory = $departmentFactory;
        $this->departmentResourceModel = $departmentResourceModel;
    }

    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }

            /** @var Department $model */
            $model = $this->departmentFactory->create();

            $id = $this->getRequest()->getParam('entity_id');
            if ($id) {
                try {
                    $model = $this->departmentRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This department no longer exists.'));

                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->departmentRepository->save($model);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }

                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the department.'));
            }

            $this->dataPersistor->set('job_department', $data);

            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
        }

        return $resultRedirect->setPath('*/*/');
    }
}
