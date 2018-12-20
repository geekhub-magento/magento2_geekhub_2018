<?php
namespace Geekhub\Lesson11;

use \Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function publicContent()
    {
        return "Publick Test Content!!!!";
        
    }

}