<?php

declare(strict_types=1);

namespace Esgi\Helloworld\Controller\Magento;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;

class Learn extends Action
{
    public function execute(): ResponseInterface
    {
        die('Magento_Learn');
    }
}
