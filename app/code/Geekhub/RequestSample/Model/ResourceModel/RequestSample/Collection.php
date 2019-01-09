<?php

namespace Geekhub\RequestSample\Model\ResourceModel\RequestSample;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * Collection constructor.
     * @param \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy
     * @param \Magento\Framework\Event\ManagerInterface $eventManager
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\DB\Adapter\AdapterInterface|null $connection
     * @param \Magento\Framework\Model\ResourceModel\Db\AbstractDb|null $resource
     */
    public function __construct(
        \Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy,
        \Magento\Framework\Event\ManagerInterface $eventManager,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection = null,
        \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(
            \Geekhub\RequestSample\Model\RequestSample::class,
            \Geekhub\RequestSample\Model\ResourceModel\RequestSample::class
        );
    }

    /**
     * @param int $storeId
     * @return Collection
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function addStoreFilter(int $storeId = 0): self
    {
        if (!$storeId) {
            $storeId = (int) $this->storeManager->getStore()->getId();
        }

        $this->addFieldToFilter('store_id', $storeId);

        return $this;
    }
}
