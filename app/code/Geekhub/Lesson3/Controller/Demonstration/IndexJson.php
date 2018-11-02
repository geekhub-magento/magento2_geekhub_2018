<?php

namespace Geekhub\Lesson3\Controller\Demonstration;

use Magento\Framework\Controller\ResultFactory;

class IndexJson extends \Magento\Framework\App\Action\Action
{
    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $controllerResult */
        $controllerResult = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $data = ['content' => "What is Parent_Theme"];

        return $controllerResult->setData($data);
    }
}
