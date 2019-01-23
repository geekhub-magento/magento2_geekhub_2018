<?php

namespace Geekhub\RequestSample\Observer\Catalog\Controller\Product\View;

use Magento\Catalog\Controller\Product\View;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Event\Observer;

class Predispatch implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var View $controllerAction */
        $controllerAction = $observer->getEvent()->getData('controller_action');
        /** @var Http $request */
        $request = $observer->getEvent()->getData('request');
    }
}
