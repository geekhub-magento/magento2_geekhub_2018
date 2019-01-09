<?php

namespace Geekhub\RequestSample\Model;

use Geekhub\RequestSample\Model\ResourceModel\RequestSample as RequestSampleResource;

/**
 * Class RequestSample
 * @package Geekhub\RequestSample\Model
 *
 * @method int|string getRequestId()
 * @method int|string getName()
 * @method RequestSample setName(string $name)
 * @method string getEmail()
 * @method RequestSample setEmail(string $email)
 * @method string getPhone()
 * @method RequestSample setPhone(string $phone)
 * @method string getProductName()
 * @method RequestSample setProductName(string $productName)
 * @method string getSku()
 * @method RequestSample setSku(string $sku)
 * @method string getRequest()
 * @method RequestSample setRequest(string $request)
 * @method string getCreatedAt()
 * @method string getStatus()
 * @method RequestSample setStatus(string $status)
 * @method int|string getStoreId()
 * @method RequestSample setStoreId(int $storeId)
 */
class RequestSample extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_PENDING = 'pending';

    const STATUS_PROCESSED = 'processed';

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb $resourceCollection
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
        $this->storeManager = $storeManager;
    }

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(RequestSampleResource::class);
    }

    /**
     * @return \Magento\Framework\Model\AbstractModel
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function beforeSave()
    {
        if (!$this->getStatus()) {
            $this->setStatus(self::STATUS_PENDING);
        }

        if (!$this->getStoreId()) {
            $this->setStoreId($this->storeManager->getStore()->getId());
        }

        return parent::beforeSave();
    }
}
