<?php
namespace Geekhub\Lesson9\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Cron\Model\Schedule;

class Status implements OptionSourceInterface
{
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        return [
            [
                'label' => __('Success'),
                'value' => Schedule::STATUS_SUCCESS,
            ],
            [
                'label' => __('Error'),
                'value' => Schedule::STATUS_ERROR,
            ],
            [
                'label' => __('Missed'),
                'value' => Schedule::STATUS_MISSED,
            ],
            [
                'label' => __('Pending'),
                'value' => Schedule::STATUS_PENDING,
            ],
            [
                'label' => __('Running'),
                'value' => Schedule::STATUS_RUNNING,
            ],
        ];
    }
}
