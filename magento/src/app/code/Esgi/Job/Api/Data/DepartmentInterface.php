<?php

declare(strict_types=1);

namespace Esgi\Job\Api\Data;

/**
 * @api
 */
interface DepartmentInterface
{
    const ID = 'entity_id';
    const TITLE = 'title';
    const CONTENT = 'content';

    public function getId(): ?string;
    public function setId($id): self;

    public function getTitle(): string;
    public function setTitle(string $title): self;

    public function getContent(): string;
    public function setContent(string $content): self;
}
