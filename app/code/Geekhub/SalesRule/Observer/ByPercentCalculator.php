<?php

namespace Geekhub\SalesRule\Observer;

use Magento\SalesRule\Model\Rule\Action\Discount\Data as DiscountData;
use Magento\Quote\Model\Quote\Item;
use Magento\SalesRule\Model\Rule;

class ByPercentCalculator implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var \Magento\SalesRule\Model\Validator
     */
    private $validator;

    /**
     * @param \Magento\SalesRule\Model\Validator $validator
     */
    public function __construct(\Magento\SalesRule\Model\Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var Rule $rule */
        $rule = $observer->getEvent()->getData('rule');

        if (
            $rule->getSimpleAction() !== Rule::BY_PERCENT_ACTION
            || $rule->getApplyActionOn() === 'apply_on_minimal_price'
        ) {
            return;
        }

        /** @var DiscountData $discountData */
        $discountData = $observer->getEvent()->getData('result');
        /** @var Item $item */
        $item = $observer->getEvent()->getData('item');
        $qty = $observer->getEvent()->getData('qty');

        // Redefine the discount percent here based on the base price
        $rulePercent = min(100, $rule->getDiscountAmount());
        // $item->setDiscountPercent(0);

        /** The below code is taken from the class
         * \Magento\SalesRule\Model\Rule\Action\Discount\ByPercent::_calculate()
         */
        $itemPrice = $this->validator->getItemPrice($item);
        $baseItemPrice = $this->validator->getItemBasePrice($item);
        $itemOriginalPrice = $this->validator->getItemOriginalPrice($item);
        $baseItemOriginalPrice = $this->validator->getItemBaseOriginalPrice($item);

        $_rulePct = $rulePercent / 100;
        // Redefine the discount percent here based on the base price
        $discountPercentFromBasePrice = 100 - ($itemPrice / $itemOriginalPrice) * 100;
        $additionalPercent = $rulePercent - $discountPercentFromBasePrice >= 0
            ? $rulePercent - $discountPercentFromBasePrice
            : 0; // no more discount if special price, tier price or catalog price rule already give discount
        $_additionalRulePct = $additionalPercent / 100;

        /* In the below two lines we use $itemOriginalPrice instead of $itemPrice
           and $baseItemOriginalPrice instead of $baseItemPrice
           because we calculate additional discount percent based on the original price.
           Some amount is already discounted and we can not use discounted price base value is incorrect
       */
        $discountData->setAmount(($qty * $itemOriginalPrice - $item->getDiscountAmount()) * $_additionalRulePct);
        $discountData->setBaseAmount(($qty * $baseItemOriginalPrice - $item->getBaseDiscountAmount()) * $_additionalRulePct);

        $discountData->setOriginalAmount(($qty * $itemOriginalPrice - $item->getDiscountAmount()) * $_rulePct);
        $discountData->setBaseOriginalAmount(
            ($qty * $baseItemOriginalPrice - $item->getBaseDiscountAmount()) * $_rulePct
        );
        // Though, let's leave item discount percent as is,
        // because it may be needed to calculate shipping discount
        /* if (!$rule->getDiscountQty() || $rule->getDiscountQty() > $qty) {
            $discountPercent = min(100, $item->getDiscountPercent() + $rulePercent);
            $item->setDiscountPercent($discountPercent);
        } */
    }
}
