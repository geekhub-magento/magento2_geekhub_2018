<?php

namespace Geekhub\ValidationCustomerData\Plugin\Checkout\Block\Checkout;

class LayoutProcessor
{
    /**
     * @param \Magento\Checkout\Block\Checkout\LayoutProcessor $subject
     * @param $jsLayout
     * @return mixed
     */
    public function afterProcess(\Magento\Checkout\Block\Checkout\LayoutProcessor $subject, $jsLayout)
    {
        $street = count($jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'])-1;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['street']['children'][$street]
        ['validation']['max_text_length'] = 100;

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['billingAddress']['children']['billing-address-fieldset']['children']['street']['children'][$street]
        ['validation']['max_text_length'] = 100;

        return $jsLayout;
    }
}
