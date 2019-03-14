<?php
if (PHP_SAPI !== 'cli') {
    echo 'bin/magento must be run as a CLI application';
    exit(1);
}

try {
    require __DIR__ . '../../../app/bootstrap.php';
} catch (\Exception $e) {
    echo 'Autoload error: ' . $e->getMessage();
    exit(1);
}

try {
    $handler = new \Magento\Framework\App\ErrorHandler();
    set_error_handler([$handler, 'handler']);
    $application = new Magento\Framework\Console\Cli('Magento CLI');

    require_once 'ProductRepository.php';

    $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
    /** @var \Geekhub\RequestSample\Model\RequestSampleGenerator $requestSampleGenerator */
    $requestSampleGenerator = $objectManager->get(\Geekhub\RequestSample\Model\RequestSampleGenerator::class);
    /** @var \Magento\Framework\App\State $state */
    $state = $objectManager->get(\Magento\Framework\App\State::class);

    $state->emulateAreaCode(
        \Magento\Framework\App\Area::AREA_ADMINHTML,
        function () use ($requestSampleGenerator) {
            foreach ($requestSampleGenerator->generate(10) as $message) {
                echo "$message\n";
            }
        }
    );
} catch (\Exception $e) {
    while ($e) {
        echo $e->getMessage();
        echo $e->getTraceAsString();
        echo "\n\n";
        $e = $e->getPrevious();
    }
    exit(Magento\Framework\Console\Cli::RETURN_FAILURE);
}
