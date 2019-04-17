<?php

namespace Esgi\Job\Controller\Adminhtml;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Registry;

abstract class Department extends \Magento\Backend\App\Action
{
    const ADMIN_RESOURCE = 'Esgi_Job::department';

    protected $_coreRegistry;

    public function __construct(Context $context, Registry $coreRegistry)
    {
        parent::__construct($context);

        $this->_coreRegistry = $coreRegistry;
    }

    protected function initPage(Page $resultPage): Page
    {
        $resultPage
            ->setActiveMenu('Esgi_Job::department')
            ->addBreadcrumb(__('Job'), __('Job'))
            ->addBreadcrumb(__('Departments'), __('Departments'));

        return $resultPage;
    }
}