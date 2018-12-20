<?php

namespace Geekhub\Lesson11\Controller\Index;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Review\Model\ReviewFactory
     */
    private $feedback;

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
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
	public function execute()
    {
        // @todo investigate how to get html version of var_dump and set to response
        var_dump($this->feedback);
        return;
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
