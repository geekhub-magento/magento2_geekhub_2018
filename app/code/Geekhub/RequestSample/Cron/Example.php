<?php

namespace Geekhub\RequestSample\Cron;

class Example
{
    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Example constructor.
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(\Psr\Log\LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->critical('Cron job is not implemented yet!');
    }
}