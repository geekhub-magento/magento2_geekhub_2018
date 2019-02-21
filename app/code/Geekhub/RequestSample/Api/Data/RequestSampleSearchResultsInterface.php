<?php

namespace Geekhub\RequestSample\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

/**
 * Interface for request sample search results.
 * @api
 */
interface RequestSampleSearchResultsInterface extends SearchResultsInterface
{
    /**
     * Get request samples list.
     *
     * @return \Geekhub\RequestSample\Api\Data\RequestSampleInterface[]
     */
    public function getItems();

    /**
     * Set request samples list.
     *
     * @param \Geekhub\RequestSample\Api\Data\RequestSampleInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}
