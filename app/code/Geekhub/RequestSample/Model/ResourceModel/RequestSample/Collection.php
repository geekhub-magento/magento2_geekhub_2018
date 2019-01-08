<?php

namespace Geekhub\RequestSample\Model\ResourceModel\RequestSample;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            \Geekhub\RequestSample\Model\RequestSample::class,
            \Geekhub\RequestSample\Model\ResourceModel\RequestSample::class
        );
    }
}
