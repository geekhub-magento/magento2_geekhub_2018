<?php

namespace Geekhub\Lesson9\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;

/**
 * Class ResponsiveItems
 */
class DynamicItems extends AbstractFieldArray
{

    protected function _prepareToRender()
    {
        $this->addColumn('job',
            [
                'label' => __('Job in grid'),
                'class' => 'required-entry',
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Viewed Job');
    }
}