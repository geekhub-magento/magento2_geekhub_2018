<?php

namespace Geekhub\RequestSample\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Request Sample CRUD interface.
 * @api
 */
interface RequestSampleRepositoryInterface
{
    /**
     * Save request sample.
     *
     * @param \Geekhub\RequestSample\Api\Data\RequestSampleInterface $requestSample
     * @return \Geekhub\RequestSample\Api\Data\RequestSampleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Geekhub\RequestSample\Api\Data\RequestSampleInterface $requestSample);

    /**
     * Retrieve request sample.
     *
     * @param int $requestSampleId
     * @return \Geekhub\RequestSample\Api\Data\RequestSampleInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($requestSampleId);

    /**
     * Retrieve request samples matching the specified criteria.
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return \Geekhub\RequestSample\Api\Data\RequestSampleSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Delete request sample.
     *
     * @param \Geekhub\RequestSample\Api\Data\RequestSampleInterface $requestSample
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Geekhub\RequestSample\Api\Data\RequestSampleInterface $requestSample);

    /**
     * Delete request sample by ID.
     *
     * @param int $requestSampleId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($requestSampleId);
}
