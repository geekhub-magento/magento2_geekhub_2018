<?php

namespace Geekhub\RequestSample\Controller\Customer;

use Geekhub\RequestSample\Api\Data\RequestSampleInterface;
use Geekhub\RequestSample\Api\RequestSampleRepositoryInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Samplerequests extends \Magento\Framework\App\Action\Action
{

    public function __construct(
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
    }

    public function execute()
    {
        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('My responses for Sample Requests'));
        $this->_view->renderLayout();
    }
}
