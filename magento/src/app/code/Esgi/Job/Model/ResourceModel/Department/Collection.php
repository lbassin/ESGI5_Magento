<?php

declare(strict_types=1);

namespace Esgi\Job\Model\ResourceModel\Department;

use Esgi\Job\Model\Department;
use Esgi\Job\Model\ResourceModel\Department as DepartmentResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(Department::class, DepartmentResourceModel::class);
    }

    public function toOptionArray(): array
    {
        return $this->_toOptionArray($this->_idFieldName, 'title');
    }
}
