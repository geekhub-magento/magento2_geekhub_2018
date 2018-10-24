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
        $geethubText = "You're so a lucky man! This is really your Day";
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        $resultPage->getLayout()->getBlock('custom.lesson.page.result')->setGeethubText($geethubText);

        return $resultPage;
    }
}