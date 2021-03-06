<?php

namespace Geekhub\RequestSample\Controller\Submit;

use Geekhub\RequestSample\Api\Data\RequestSampleInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;

class Index extends \Magento\Framework\App\Action\Action
{
    const STATUS_ERROR = 'Error';

    const STATUS_SUCCESS = 'Success';

    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     */
    private $formKeyValidator;

    /**
     * @var \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory
     */
    private $requestSampleFactory;

    /**
     * @var \Geekhub\RequestSample\Api\RequestSampleRepositoryInterface $requestSampleRepository
     */
    private $requestSampleRepository;

    /**
     * @var \Geekhub\RequestSample\Helper\Mail $mailHelper
     */
    private $mailHelper;

    /**
     * Index constructor.
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory
     * @param \Geekhub\RequestSample\Api\RequestSampleRepositoryInterface $requestSampleRepository
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Geekhub\RequestSample\Helper\Mail $mailHelper
     */
    public function __construct(
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Geekhub\RequestSample\Model\RequestSampleFactory $requestSampleFactory,
        \Geekhub\RequestSample\Api\RequestSampleRepositoryInterface $requestSampleRepository,
        \Geekhub\RequestSample\Helper\Mail $mailHelper,
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->formKeyValidator = $formKeyValidator;
        $this->requestSampleFactory = $requestSampleFactory;
        $this->requestSampleRepository = $requestSampleRepository;
        $this->mailHelper = $mailHelper;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {
        /** @var Http $request */
        $request = $this->getRequest();

        try {
            if (!$this->formKeyValidator->validate($request) || $request->getParam('hideit')) {
                throw new LocalizedException(__('Something went wrong. Probably you were away for quite a long time already. Please, reload the page and try again.'));
            }

            if (!$request->isAjax()) {
                throw new LocalizedException(__('This request is not valid and can not be processed.'));
            }

            // @TODO: #111 Backend form validation
            // Here we must also process backend validation or all form fields.
            // Otherwise attackers can just copy our page, remove fields validation and send anything they want

            /** @var RequestSampleInterface $requestSample */
            $requestSample = $this->requestSampleFactory->create();
            $requestSample->setName($request->getParam('name'))
                ->setEmail($request->getParam('email'))
                ->setPhone($request->getParam('phone'))
                ->setProductName($request->getParam('product_name'))
                ->setSku($request->getParam('sku'))
                ->setRequest($request->getParam('request'));

            $this->requestSampleRepository->save($requestSample);

            /**
             * Send Email
             */
            if ($request->getParam('email')) {
                $email = $request->getParam('email');
                $customerName = $request->getParam('name');
                $message = $request->getParam('request');

                $this->mailHelper->sendMail($email, $customerName, $message);
            }
            $data = [
                'status' => self::STATUS_SUCCESS,
                'message' => 'Your request was submitted. We\'ll get in touch with you as soon as possible.'
            ];
        } catch (LocalizedException $e) {
            $data = [
                'status'  => self::STATUS_ERROR,
                'message' => $e->getMessage()
            ];
        }

        /**
         * @var \Magento\Framework\Controller\Result\Json $controllerResult
         */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);

        return $controllerResult->setData($data);
    }
}
