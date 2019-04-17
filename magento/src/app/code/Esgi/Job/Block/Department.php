<?php

declare(strict_types=1);

namespace Esgi\Job\Block;

use Esgi\Job\Model\ResourceModel\Department\CollectionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Department extends Template
{
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory, Context $context, array $data = [])
    {
        $this->collectionFactory = $collectionFactory;

        parent::__construct($context, $data);
    }

    public function getDepartments(): array
    {
        $collection = $this->collectionFactory->create();

        return $collection->getItems();
    }
}