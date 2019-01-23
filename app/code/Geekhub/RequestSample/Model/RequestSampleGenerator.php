<?php

namespace Geekhub\RequestSample\Model;

use Magento\Framework\DB\Transaction;
use Magento\Catalog\Api\Data\ProductInterface;

class RequestSampleGenerator
{
    /**
     * @var \Magento\Catalog\Model\ProductRepository\Proxy
     */
    private $productRepository;
    /**
     * @var \Magento\Framework\Api\SearchCriteria
     */
    private $criteria;
    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;
    /**
     * @var RequestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * RequestSampleGenerator constructor.
     * @param \Magento\Catalog\Model\ProductRepository\Proxy $productRepository
     * @param \Magento\Framework\Api\SearchCriteria $criteria
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param RequestSampleFactory $requestSampleFactory
     */
    public function __construct(
        \Magento\Catalog\Model\ProductRepository\Proxy $productRepository,
        \Magento\Framework\Api\SearchCriteria $criteria,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory
    ) {
        $this->productRepository = $productRepository;
        $this->criteria = $criteria;
        $this->transactionFactory = $transactionFactory;
        $this->requestSampleFactory = $requestSampleFactory;
    }

    /**
     * @param int $count
     * @return \Generator
     * @throws \Exception
     */
    public function generate(int $count): \Generator
    {
        $i = 0;
        /** @var Transaction $transaction */
        $transaction = $this->transactionFactory->create();
        $this->criteria->setPageSize(100);
        $products = $this->productRepository->getList($this->criteria)
            ->getItems();

        while ($i < $count) {
            ++$i;
            /** @var ProductInterface $product */
            $product = $products[array_rand($products)];

            /** @var RequestSample $requestSample */
            $requestSample = $this->requestSampleFactory->create();
            $requestSample->setName("Test name $i")
                ->setEmail("email-$i@example.com")
                ->setPhone('888-88-88')
                ->setProductName($product->getName())
                ->setSku($product->getSku())
                ->setRequest("Lorem upsum #$i");

            $transaction->addObject($requestSample);
            yield "Generated item #$i...";
        }

        $transaction->save();
        yield "Completed!";
    }
}
