<?php

declare(strict_types=1);

namespace Esgi\Job\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Department extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('esgi_job_department', 'entity_id');
    }
}
