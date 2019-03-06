<?php

namespace Geekhub\RequestSample\Setup;

use Magento\Framework\DB\Transaction;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Component\ComponentRegistrar;
use Magento\Store\Model\Store;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Source\Boolean;
use Geekhub\RequestSample\Model\RequestSample;

class UpgradeData implements UpgradeDataInterface
{
    /**
     * @var \Geekhub\RequestSample\Model\RequestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * @var \Magento\Framework\File\Csv $csv
     */
    private $csv;

    /**
     * @var \Magento\Framework\Component\ComponentRegistrar $componentRegistrar
     */
    private $componentRegistrar;

    /**
     * @var \Magento\Framework\DB\TransactionFactory
     */
    private $transactionFactory;

    /**
     * @var \Magento\Eav\Setup\EavSetupFactory
     */
    private $eavSetupFactory;


    /**
     * @var \Magento\Customer\Model\Attribute
     */
    private $customerAttribute;

    /**
     * UpgradeData constructor.
     * @param \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory
     * @param \Magento\Framework\Component\ComponentRegistrar $componentRegistrar
     * @param \Magento\Framework\File\Csv $csv
     * @param \Magento\Framework\DB\TransactionFactory $transactionFactory
     * @param \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory
     * @param \Magento\Customer\Model\Attribute $customerAttribute
     */
    public function __construct(
        \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory,
        \Magento\Framework\Component\ComponentRegistrar $componentRegistrar,
        \Magento\Framework\File\Csv $csv,
        \Magento\Framework\DB\TransactionFactory $transactionFactory,
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Customer\Model\Attribute $customerAttribute
    ) {
        $this->requestSampleFactory = $requestSampleFactory;
        $this->componentRegistrar = $componentRegistrar;
        $this->csv = $csv;
        $this->transactionFactory = $transactionFactory;
        $this->eavSetupFactory = $eavSetupFactory;
        $this->customerAttribute = $customerAttribute;
    }

    /**
     * {@inheritdoc}
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.2', '<')) {
            $statuses = [RequestSample::STATUS_PENDING, RequestSample::STATUS_PROCESSED];
            /** @var Transaction $transaction */
            $transaction = $this->transactionFactory->create();

            for ($i = 1; $i <= 5; $i++) {
                /** @var RequestSample $requestSample */
                $requestSample = $this->requestSampleFactory->create();
                $requestSample->setName("Customer #$i")
                    ->setEmail("test-mail-$i@gmail.com")
                    ->setPhone("+38093-$i$i$i-$i$i-$i$i")
                    ->setProductName("Product #$i")
                    ->setSku("product_sku_$i")
                    ->setRequest('Just a test request')
                    ->setStatus($statuses[array_rand($statuses)])
                    ->setStoreId(Store::DISTRO_STORE_ID);
                $transaction->addObject($requestSample);
            }

            $transaction->save();
        }

        if (version_compare($context->getVersion(), '1.0.3') < 0) {
            $this->updateDataForRequestSample($setup, 'import_data.csv');
        }

        if (version_compare($context->getVersion(), '1.0.4') < 0) {
            $this->createAllowRequestSampleCustomerAttribute($setup);
        }
        $setup->endSetup();
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param $fileName
     * @throws \Exception
     */
    public function updateDataForRequestSample(ModuleDataSetupInterface $setup, $fileName)
    {
        $tableName = $setup->getTable('geekhub_request_sample');
        $filePath = $this->getPathToCsvMagentoAtdec($fileName);
        $csvData = $this->csv->getData($filePath);

        if ($setup->getConnection()->isTableExists($tableName)) {
            foreach ($csvData as $row => $data) {
                if (count($data) === 9) {
                    $res = $this->getCsvData($data);
                    $setup->getConnection()->insertOnDuplicate(
                        $tableName,
                        $res,
                        [
                            'name',
                            'email',
                            'phone',
                            'product_name',
                            'sku',
                            'request',
                            'created_at',
                            'status',
                            'store_id',
                        ]
                    );
                }
            }
        }
    }

    public function createAllowRequestSampleCustomerAttribute($setup)
    {
        $code = 'allow_request_sample';
        /** @var \Magento\Eav\Setup\EavSetup $eavSetup */
        $eavSetup = $this->eavSetupFactory->create(['setup' => $setup]);
        $eavSetup->addAttribute(
            Customer::ENTITY,
            'allow_request_sample',
            [
                'type'         => 'int',
                'label'        => 'Allow Request a Quote',
                'input'        => 'select',
                'source'       => Boolean::class,
                'required'     => false,
                'visible'      => false,
                'user_defined' => true,
                'position'     => 999,
                'system'       => 0,
                'default'      => 1,
                'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
            ]
        );

        $attribute = $this->customerAttribute->loadByCode(Customer::ENTITY, $code);

        $attribute->addData([
            'attribute_set_id' => 1,
            'attribute_group_id' => 1,
            'used_in_forms' => ['adminhtml_customer', 'customer_account_edit'],
            ])->save();
    }

    /**
     * @param $fileName
     * @return string
     */
    private function getPathToCsvMagentoAtdec($fileName)
    {
        return $this->componentRegistrar->getPath(ComponentRegistrar::MODULE, 'Geekhub_RequestSample') .
            DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . $fileName;
    }

    /**
     * @param $data
     * @return array
     */
    private function getCsvData($data)
    {
        return [
            'name' => $data[0],
            'email' => $data[1],
            'phone' => $data[2],
            'product_name' => $data[3],
            'sku' => $data[4],
            'request' => $data[5],
            'created_at' => $data[6],
            'status' => $data[7],
            'store_id' => $data[8],
        ];
    }
}
