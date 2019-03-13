<?php
namespace Geekhub\CustomerOrder\Controller\Customer;

class Order extends \Magento\Framework\App\Action\Action
{
    public function execute()
    {
        return $this->resultFactory->create(\Magento\Framework\Controller\ResultFactory::TYPE_PAGE);
    }
}
