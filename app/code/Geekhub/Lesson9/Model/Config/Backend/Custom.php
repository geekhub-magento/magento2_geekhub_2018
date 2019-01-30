<?php

namespace Geekhub\Lesson9\Model\Config\Backend;
/**
 * Class Custom
 * @package Geekhub\Lesson9\Model\Config\Backend
 */
class Custom extends \Magento\Framework\App\Config\Value
{
    protected $configValue;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\App\Config\ScopeConfigInterface $config,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Config\ValueFactory $configValueFactory,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->configValue = $configValueFactory;
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    public function beforeSave()
    {
        $label = $this->getData('field_config/label');

        if ($this->getValue() == '') {
            throw new \Magento\Framework\Exception\ValidatorException(__($label . ' is required.'));
        } else if (is_numeric($this->getValue())) {
            throw new \Magento\Framework\Exception\ValidatorException(__($label . ' is not a text.'));
        } else if (strlen($this->getValue()) < 5) {
            throw new \Magento\Framework\Exception\ValidatorException(__($label . ' too short word, Minimum 5 letters'));
        }

        $this->setValue($this->getValue());

        parent::beforeSave();
    }

    public function afterSave()
    {

        $value = $this->getValue();

        try {
            $this->configValue->create()->load(
                'geekhub_crone_options/general/display_text_dis',
                'path'
            )->setValue(
                $value
            )->setPath(
                'geekhub_crone_options/general/display_text_dis'
            )->save();
        } catch (\Exception $e) {
            throw new \Exception(__('We can\'t save new option.'));
        }


        return parent::afterSave();
    }
}