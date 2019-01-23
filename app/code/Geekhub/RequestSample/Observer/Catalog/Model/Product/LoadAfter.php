<?php

namespace Geekhub\RequestSample\Observer\Catalog\Model\Product;

use Magento\Catalog\Model\Product;
use Magento\Framework\Event\Observer;

class LoadAfter implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        /** @var Product $product */
        $product = $observer->getEvent()->getData('product');
    }
}
