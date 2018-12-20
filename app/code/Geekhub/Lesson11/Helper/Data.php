<?php
namespace Geekhub\Lesson11\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * Class Data
 * @package Geekhub\Lesson11\Helper
 */
class Data extends AbstractHelper implements ArgumentInterface
{
    /**
     * Data constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * @return string
     */
    public function publicContent()
    {
        return "THIS IS BANNER!!!!!!";
        
    }

}