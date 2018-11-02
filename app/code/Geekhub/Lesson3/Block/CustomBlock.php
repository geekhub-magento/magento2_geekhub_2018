<?php

namespace Geekhub\Lesson3\Block;

class CustomBlock extends \Magento\Framework\View\Element\Template
{
    const GEETHUB_TEMPLATE = "Geekhub_Lesson3::lesson/testTemplate.phtml";

    /**
     * add custom template
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->setTemplate(self::GEETHUB_TEMPLATE);

        return $this;
    }
}
