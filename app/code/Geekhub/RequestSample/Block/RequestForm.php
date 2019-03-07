<?php

namespace Geekhub\RequestSample\Block;

use Magento\Catalog\Api\ProductRepositoryInterface;

class RequestForm extends \Magento\Catalog\Block\Product\View
{
    public function __construct(
        \Magento\Catalog\Block\Product\Context $context, \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $urlEncoder,
            $jsonEncoder,
            $string,
            $productHelper,
            $productTypeConfig,
            $localeFormat,
            $customerSession,
            $productRepository,
            $priceCurrency,
            $data
        );
    }


    /**
     * @return int
     */
    public function getCurrentCustomerId()
    {
        $currentCustomer = $this->customerSession->getCustomer();

        return $currentCustomer ? $currentCustomer->getId() : 0;
    }
}