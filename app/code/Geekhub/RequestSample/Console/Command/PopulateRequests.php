<?php

namespace Geekhub\RequestSample\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\Framework\DB\Transaction;
use Magento\Framework\App\Area;
use Magento\Catalog\Api\Data\ProductInterface;
use Geekhub\RequestSample\Model\RequestSample;

class PopulateRequests extends \Symfony\Component\Console\Command\Command
{
    const DEFAULT_COUNT = 20;

    /**
     * @var \Magento\Catalog\Model\ProductRepository\Proxy
     */
    private $productRepository;

    /**
     * @var \Magento\Framework\Api\SearchCriteria
     */
    private $criteria;

    /**
     * @var \Geekhub\RequestSample\Model\RequestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * PopulateRequests constructor.
     * @param \Magento\Catalog\Model\ProductRepository\Proxy $productRepository
     * @param \Magento\Framework\Api\SearchCriteria $criteria
     * @param \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param \Magento\Framework\App\State $state
     * @param string|null $name
     */
    public function __construct(
        \Magento\Catalog\Model\ProductRepository\Proxy $productRepository,
        \Magento\Framework\Api\SearchCriteria $criteria,
        \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Framework\App\State $state,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->productRepository = $productRepository;
        $this->criteria = $criteria;
        $this->requestSampleFactory = $requestSampleFactory;
        $this->transactionFactory = $transactionFactory;
        $this->state = $state;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('request-sample:populate-requests')
            ->setDescription('Populate sample requests. Can pass `count` argument')
            ->setDefinition([
                new InputArgument(
                    'count',
                    InputArgument::OPTIONAL,
                    'Count'
                )
            ]);
        parent::configure();
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->setAreaCode(Area::AREA_ADMINHTML);
            $count = $input->getArgument('count') ?: self::DEFAULT_COUNT;
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
                $output->writeln("<info>Generated item #$i...<info>");
            }

            $transaction->save();
            $output->writeln("<info>Completed!<info>");
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}<error>");
        }
    }
}
