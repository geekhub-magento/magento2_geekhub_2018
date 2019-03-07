<?php

namespace Geekhub\RequestSample\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;

class RequestForm extends \Magento\Catalog\Block\Product\View
{
    /**
     * @return int
     */
    public function getCurrentCustomerId(): int
    {
        $currentCustomer = $this->customerSession->getCustomer();

        return $currentCustomer ? (int) $currentCustomer->getId() : 0;
    }
}