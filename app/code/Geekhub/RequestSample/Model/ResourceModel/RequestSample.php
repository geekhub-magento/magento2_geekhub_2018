<?php

namespace Geekhub\RequestSample\Model\ResourceModel;

class RequestSample extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    protected function _construct()
    {
        $this->_init('geekhub_request_sample', 'request_id');
    }
}
