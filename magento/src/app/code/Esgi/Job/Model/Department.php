<?php

declare(strict_types=1);

namespace Esgi\Job\Model;

use Esgi\Job\Api\Data\DepartmentInterface;
use Esgi\Job\Model\ResourceModel\Department as DepartmentResourceModel;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Department extends AbstractModel implements DepartmentInterface, IdentityInterface
{
    const CACHE_TAG = 'esgi_job_d';

    protected $_cacheTag = self::CACHE_TAG;
    protected $_eventPrefix = 'esgi_job';
    protected $_eventObject = 'department';
    protected $_idFieldName = 'entity_id';

    protected function _construct()
    {
        $this->_init(DepartmentResourceModel::class);
    }

    public function getIdentities(): array
    {
        return [self::CACHE_TAG.'_'.$this->getId()];
    }

    public function getId(): ?string
    {
        return $this->getData(self::ID);
    }

    public function setId($id): DepartmentInterface
    {
        return $this->setData(self::ID, $id);
    }

    public function getTitle(): string
    {
        return $this->getData(self::TITLE);
    }

    public function setTitle(string $title): DepartmentInterface
    {
        return $this->setData(self::TITLE, $title);
    }

    public function getContent(): string
    {
        return $this->getData(self::CONTENT);
    }

    public function setContent(string $content): DepartmentInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    public function beforeSave(): AbstractModel
    {
        if ($this->hasDataChanges()) {
            $this->setUpdateTime(null);
        }

        return parent::beforeSave();
    }
}
