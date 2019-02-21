<?php

namespace Geekhub\RequestSample\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Geekhub\RequestSample\Api\Data\RequestSampleInterface;
use Geekhub\RequestSample\Api\Data\RequestSampleInterfaceFactory;
use Geekhub\RequestSample\Api\Data\RequestSampleSearchResultsInterfaceFactory;
use Geekhub\RequestSample\Api\RequestSampleRepositoryInterface;
use Geekhub\RequestSample\Model\ResourceModel\RequestSample as ResourceRequestSample;
use Geekhub\RequestSample\Model\ResourceModel\RequestSample\CollectionFactory as RequestSampleCollectionFactory;

/**
 * Class RequestSampleRepository
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class RequestSampleRepository implements RequestSampleRepositoryInterface
{
    /**
     * @var ResourceRequestSample
     */
    protected $resource;

    /**
     * @var RequestSampleFactory
     */
    protected $requestSampleFactory;

    /**
     * @var RequestSampleCollectionFactory
     */
    protected $requestSampleCollectionFactory;

    /**
     * @var RequestSampleInterfaceFactory
     */
    protected $dataRequestSampleFactory;

    /**
     * @var RequestSampleSearchResultsInterfaceFactory
     */
    protected $searchResultsFactory;

    /**
     * @var DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @param ResourceRequestSample $resource
     * @param RequestSampleFactory $requestSampleFactory
     * @param RequestSampleCollectionFactory $requestSampleCollectionFactory
     * @param RequestSampleInterfaceFactory $dataRequestSampleFactory
     * @param RequestSampleSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     */
    public function __construct(
        ResourceRequestSample $resource,
        RequestSampleFactory $requestSampleFactory,
        RequestSampleCollectionFactory $requestSampleCollectionFactory,
        RequestSampleInterfaceFactory $dataRequestSampleFactory,
        RequestSampleSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor
    ) {
        $this->resource = $resource;
        $this->requestSampleFactory = $requestSampleFactory;
        $this->requestSampleCollectionFactory = $requestSampleCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataRequestSampleFactory = $dataRequestSampleFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
    }

    /**
     * Save RequestSample data
     *
     * @param RequestSampleInterface $requestSample
     * @return RequestSampleInterface
     * @throws CouldNotSaveException
     */
    public function save(RequestSampleInterface $requestSample)
    {
        try {
            $this->resource->save($requestSample);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $requestSample;
    }

    /**
     * Load RequestSample data by given RequestSample Identity
     *
     * @param string $requestSampleId
     * @return RequestSampleInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($requestSampleId)
    {
        $requestSample = $this->requestSampleFactory->create();
        $this->resource->load($requestSample, $requestSampleId);
        if (!$requestSample->getId()) {
            throw new NoSuchEntityException(__('RequestSample with id "%1" does not exist.', $requestSampleId));
        }
        return $requestSample;
    }

    /**
     * Load RequestSample data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Geekhub\RequestSample\Model\ResourceModel\RequestSample\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);

        $collection = $this->requestSampleCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        $searchResults->setTotalCount($collection->getSize());
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        $requestSamples = [];
        /** @var RequestSample $requestSampleModel */
        foreach ($collection as $requestSampleModel) {
            $requestSampleData = $this->dataRequestSampleFactory->create();
            $this->dataObjectHelper->populateWithArray(
                $requestSampleData,
                $requestSampleModel->getData(),
                'Geekhub\RequestSample\Api\Data\RequestSampleInterface'
            );
            $requestSamples[] = $this->dataObjectProcessor->buildOutputDataArray(
                $requestSampleData,
                'Geekhub\RequestSample\Api\Data\RequestSampleInterface'
            );
        }
        $searchResults->setItems($requestSamples);
        return $searchResults;
    }

    /**
     * Delete RequestSample
     *
     * @param RequestSampleInterface $requestSample
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(RequestSampleInterface $requestSample)
    {
        try {
            $this->resource->delete($requestSample);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete RequestSample by given RequestSample Identity
     *
     * @param string $requestSampleId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($requestSampleId)
    {
        return $this->delete($this->getById($requestSampleId));
    }
}
