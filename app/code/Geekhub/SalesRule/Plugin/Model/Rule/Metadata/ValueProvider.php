<?php

namespace Geekhub\SalesRule\Plugin\Model\Rule\Metadata;

use Magento\SalesRule\Model\Rule;

/**
 * Metadata provider for sales rule edit form.
 */
class ValueProvider
{
    const APPLY_ON_PRICE = 'apply_on_price';

    const APPLY_ON_MINIMAL_PRICE = 'apply_on_minimal_price';

    /**
     * Get metadata for sales rule form. It will be merged with form UI component declaration.
     *
     * @param Rule\Metadata\ValueProvider $subject
     * @param array $result
     * @return array
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function afterGetMetadataValues(
        \Magento\SalesRule\Model\Rule\Metadata\ValueProvider $subject,
        $result
    ) {
        $applyActionOnOptions = [
            [
                'label' => __('Apply on Price'),
                'value' =>  self::APPLY_ON_PRICE
            ], [
                'label' => __('Apply on Minimal Price'),
                'value' => self::APPLY_ON_MINIMAL_PRICE
            ]
        ];

        return array_merge_recursive(
            $result,
            [
                'actions' => [
                    'children' => [
                        'apply_action_on' => [
                            'arguments' => [
                                'data' => [
                                    'config' => [
                                        'options' => $applyActionOnOptions
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        );
    }
}
