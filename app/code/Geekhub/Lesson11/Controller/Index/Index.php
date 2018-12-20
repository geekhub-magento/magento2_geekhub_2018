<?php

namespace Geekhub\Lesson11\Controller\Index;

use Geekhub\Lesson11\Model\Feedback;
use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Review\Model\ReviewFactory
     */
    private $feedback;

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    private $objectManager;

    /**
     * Index constructor.
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Review\Model\ReviewFactory $reviewFactory
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Geekhub\Lesson11\Model\Feedback $feedback
    ) {
        parent::__construct($context);
        $this->feedback= $feedback;
        $this->objectManager = $context->getObjectManager();
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
	public function execute()
    {
        // @todo investigate how to get html version of var_dump and set to response
        var_dump($this->feedback);

        $feedbackObject = $this->objectManager->get(Feedback::class);
        $feedbackObject->setName('vasya');
        var_dump($feedbackObject);
        $feedbackObject2 = $this->objectManager->get(Feedback::class);
        var_dump($feedbackObject2);
        $feedbackObject3 = $this->objectManager->create(Feedback::class, ['name' => 'Kolya']);
        var_dump($feedbackObject3);
        $feedbackObject4 = $this->objectManager->get(Feedback::class);
        var_dump($feedbackObject4);

        return;
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
