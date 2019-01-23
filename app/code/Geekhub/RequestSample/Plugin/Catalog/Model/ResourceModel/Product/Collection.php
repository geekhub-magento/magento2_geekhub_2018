<?php

namespace Geekhub\RequestSample\Plugin\Catalog\Model\ResourceModel\Product;

use Magento\Catalog\Model\ResourceModel\Product\Collection as ProductCollection;

class Collection
{
    /**
     * @param ProductCollection $subject
     * @param bool $printQuery
     * @param bool $logQuery
     * @return array
     */
    public function beforeLoad(ProductCollection $subject, $printQuery = false, $logQuery = false)
    {
        // Arguments can be omitted
        $class = get_class($subject);
        // Can optionally modify method arguments here and return them as array
        // return [true, true];
    }

    /**
     * @param ProductCollection $subject
     * @param \Closure $proceed
     * @param bool $printQuery
     * @param bool $logQuery
     * @return ProductCollection
     */
    public function aroundLoad(ProductCollection $subject, \Closure $proceed, $printQuery = false, $logQuery = false)
    {
        // Arguments must be accepted and passed to the $proceed call
        $result = $proceed($printQuery, $logQuery);
        $class = get_class($subject);
        return $result;
    }

    /**
     * @param ProductCollection $subject
     * @param $result
     * @return ProductCollection
     */
    public function afterLoad(ProductCollection $subject, $result /*, $printQuery = false, $logQuery = false*/)
    {
        // Arguments can be omitted
        // Can modify and return result if needed
        $class = get_class($subject);
        return $subject;
    }
}
