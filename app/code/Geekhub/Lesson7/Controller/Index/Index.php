<?php

namespace Geekhub\Lesson7\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action{

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     */
	public function execute(){
        $this->_view->loadLayout();
        $this->_view->renderLayout();
    }
}
