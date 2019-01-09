<?php

namespace Geekhub\RequestSample\Block;

use Geekhub\RequestSample\Model\ResourceModel\RequestSample\Collection;

class Requests extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Geekhub\RequestSample\Model\ResourceModel\RequestSample\CollectionFactory
     */
    private $collectionFactory;

    /**
     * Requests constructor.
     * @param \Geekhub\RequestSample\Model\ResourceModel\RequestSample\CollectionFactory $collectionFactory
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param array $data
     */
    public function __construct(
        \Geekhub\RequestSample\Model\ResourceModel\RequestSample\CollectionFactory $collectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @return Collection
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
}
