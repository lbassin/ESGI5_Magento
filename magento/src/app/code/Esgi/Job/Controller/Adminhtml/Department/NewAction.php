<?php

declare(strict_types=1);

namespace Esgi\Job\Controller\Adminhtml\Department;

use Esgi\Job\Controller\Adminhtml\Department;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Forward;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Framework\Registry;

class NewAction extends Department
{
    protected $resultForwardFactory;

    public function __construct(Context $context, Registry $coreRegistry, ForwardFactory $resultForwardFactory)
    {
        parent::__construct($context, $coreRegistry);

        $this->resultForwardFactory = $resultForwardFactory;
    }

    public function execute(): Forward
    {
        /** @var Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}
