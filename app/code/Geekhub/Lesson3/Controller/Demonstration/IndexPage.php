<?php

namespace Geekhub\Lesson3\Controller\Demonstration;

use Magento\Framework\Controller\ResultFactory;

class IndexPage extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {

        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage ->addHandle('custom_handle');

        return $resultPage;
    }
}