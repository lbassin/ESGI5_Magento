<?php

declare(strict_types=1);

namespace Esgi\Job\Controller\Department;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $resultPageFactory;

    public function __construct(Context $context, PageFactory $resultPageFactory)
    {
        $this->resultPageFactory = $resultPageFactory;

        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        $resultPage = $this->resultPageFactory->create();

        $resultPage->getConfig()->getTitle()->set(__('Job Department Index'));

        return $resultPage;
    }
}