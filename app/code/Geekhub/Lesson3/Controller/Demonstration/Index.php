<?php

namespace Geekhub\Lesson3\Controller\Demonstration;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
    public function execute()
    {
        die("Hello 😉 - Geekhub\\Lesson3\\Controller\\Demonstration\\Index - execute() method");
    }
}