<?php

declare(strict_types=1);

namespace Esgi\Helloworld\Block;

use Magento\Framework\View\Element\Template;

class Hello extends Template
{
    public function sayHello(string $name): string
    {
        return sprintf('Hello %s', $name);
    }
}