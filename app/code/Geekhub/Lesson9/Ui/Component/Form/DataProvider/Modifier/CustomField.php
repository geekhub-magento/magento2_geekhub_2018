<?php
namespace Geekhub\Lesson9\Ui\Component\Form\DataProvider\Modifier;

use Magento\Ui\Component\Form;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

class CustomField implements ModifierInterface
{
    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyMeta(array $meta)
    {
        $meta['general']['children']['custom_field'] = [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Form\Field::NAME,
                        'formElement'   => Form\Element\Input::NAME,
                        'label'         => __('Custom Field'),
                        'dataType'      => Form\Element\DataType\Text::NAME,
                        'sortOrder'     => 45,
                        'dataScope'     => 'custom_field',
                    ]
                ]
            ],
        ];

        return $meta;
    }
}
