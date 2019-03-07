<?php

namespace Geekhub\RequestSample\Observer;

use Magento\Framework\Event\Observer;

class LayoutGenerateBlocksAfter implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\Framework\Registry
     */
    protected $registry;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    public function __construct(
        \Magento\Framework\Registry $registry,
        \Magento\Customer\Model\Session $customerSession
    ) {
        $this->registry = $registry;
        $this->customerSession = $customerSession;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        $product = $this->registry->registry('current_product');

        if (!$product) {
            return $this;
        }

        if ($this->requestFormDisallowed()) {
            $layout = $observer->getLayout();
            $sampleRequestBlock = $layout->getBlock('request.sample.tab');
            if ($sampleRequestBlock) {
                $sampleRequestBlock->setTemplate('');
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    private function requestFormDisallowed()
    {
        return !$this->customerSession->getCustomer()->getAllowRequestSample();
    }
}
