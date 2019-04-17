<?php

declare(strict_types=1);

namespace Esgi\Job\Model\Department;

use Esgi\Job\Model\ResourceModel\Department\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $collection;
    protected $dataPersistor;
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $departmentCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);

        $this->collection = $departmentCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
    }

    public function getData(): ?array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();

        /** @var \Esgi\Job\Model\Department $department */
        foreach ($items as $department) {
            $this->loadedData[$department->getId()] = $department->getData();
        }

        $data = $this->dataPersistor->get('job_department');

        if (!empty($data)) {
            $department = $this->collection->getNewEmptyItem();
            $department->setData($data);
            $this->loadedData[$department->getId()] = $department->getData();
            $this->dataPersistor->clear('job_department');
        }

        return $this->loadedData;
    }
}
