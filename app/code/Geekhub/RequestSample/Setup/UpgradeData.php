<?php

namespace Geekhub\RequestSample\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Store\Model\Store;
use Geekhub\RequestSample\Model\RequestSample;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * UpgradeData constructor.
     * @param \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory
     */
    public function __construct(\Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory)
    {
        $this->requestSampleFactory = $requestSampleFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            for ($i = 1; $i <= 5; $i++) {
                /** @var RequestSample $requestSample */
                $requestSample = $this->requestSampleFactory->create();
                $requestSample->setName("Customer #$i")
                    ->setEmail("test-mail-$i@gmail.com")
                    ->setPhone("+38093-$i$i$i-$i$i-$i$i")
                    ->setProductName("Product #$i")
                    ->setSku("product_sku_$i")
                    ->setRequest('Just a test request')
                    ->setStatus(array_rand([RequestSample::STATUS_PENDING, RequestSample::STATUS_PROCESSED]))
                    ->setStoreId(Store::DISTRO_STORE_ID);
                $requestSample->save();
            }
        }
    }
}
