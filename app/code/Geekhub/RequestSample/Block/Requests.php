<?php

namespace Geekhub\RequestSample\Block;

use Geekhub\RequestSample\Model\ResourceModel\RequestSample\Collection;

class Requests extends \Magento\Framework\View\Element\Template
{
    const CUSTOMERS_LIMIT = 10;
    /**
     * @var \Geekhub\RequestSample\Model\ResourceModel\RequestSample\CollectionFactory
     */
    private $collectionFactory;

    private $customerSession;

    /**
     * Requests constructor.
     * @param \Geekhub\RequestSample\Model\ResourceModel\RequestSample\CollectionFactory $collectionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Geekhub\RequestSample\Model\ResourceModel\RequestSample\CollectionFactory $collectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->customerSession = $customerSession;
    }

    /**
     * @return Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getSampleRequests(): Collection
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter()
            ->getSelect()
            ->orderRand();

        if ($limit = $this->getData('limit')) {
            $collection->setPageSize($limit);
        }

        return $collection;
    }

    private function getSampleRequestsByCustomer(\Magento\Customer\Model\Customer $customer): Collection
    {
        if (!$customer) {
            throwException('No customer has been found!');
        }

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addStoreFilter()
            ->getSelect()
            ->orderRand();

        $collection->addFieldToFilter('customer', ['eq' => $customer->getId()]);

        $limit = $this->getData('limit') ?: self::CUSTOMERS_LIMIT;
        $collection->setPageSize($limit);

        return $collection;
    }

    public function getMySampleRequests()
    {
        $currentCustomer = $this->customerSession->getCustomer();

        return $this->getSampleRequestsByCustomer($currentCustomer);
    }
}
