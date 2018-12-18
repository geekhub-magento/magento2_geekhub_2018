<?php

namespace Geekhub\CmsExamples\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;

class SpecialLink extends Template implements BlockInterface
{
    /**
     * @var string
     */
    protected $_template = "widget/samplewidget.phtml";

    public function getButtonTitle($code)
    {
        $result = false;
        switch ($code) {
            case 'add_to_cart':
                $result = __("Add to Cart");
                break;
            case 'add_to_wishlist':
                $result = __("Add to Wishlist");
                break;
            case 'add_to_compare':
                $result = __("Add to Compare");
                break;
        }

        return $result;
    }
}
