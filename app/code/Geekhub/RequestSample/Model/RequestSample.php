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

    protected function _construct()
    {
        $this->_init(RequestSampleResource::class);
    }
}
