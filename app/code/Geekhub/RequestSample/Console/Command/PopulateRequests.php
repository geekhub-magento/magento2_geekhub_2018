<?php

namespace Geekhub\RequestSample\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Magento\Framework\App\Area;

class PopulateRequests extends \Symfony\Component\Console\Command\Command
{
    const DEFAULT_COUNT = 20;

    /**
     * @var \Geekhub\RequestSample\Model\RequestSampleGenerator
     */
    private $requestSampleGenerator;

    /**
     * @var \Magento\Framework\App\State
     */
    private $state;

    /**
     * PopulateRequests constructor.
     * @param \Geekhub\RequestSample\Model\RequestSampleGenerator $requestSampleGenerator
     * @param \Magento\Framework\App\State $state
     * @param string|null $name
     */
    public function __construct(
        \Geekhub\RequestSample\Model\RequestSampleGenerator $requestSampleGenerator,
        \Magento\Framework\App\State $state,
        ?string $name = null
    ) {
        parent::__construct($name);
        $this->state = $state;
        $this->requestSampleGenerator = $requestSampleGenerator;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        $this->setName('request-sample:populate-requests')
            ->setDescription('Populate sample requests. Can pass `count` argument')
            ->setDefinition([
                new InputArgument(
                    'count',
                    InputArgument::OPTIONAL,
                    'Count'
                )
            ]);
        parent::configure();
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->state->emulateAreaCode(
                Area::AREA_ADMINHTML,
                function (int $count) use ($output) {
                    foreach ($this->requestSampleGenerator->generate($count) as $message) {
                        $output->writeln("<info>$message</info>");
                    }
                },
                [
                    $input->getArgument('count') ?: self::DEFAULT_COUNT
                ]
            );
        } catch (\Exception $e) {
            $output->writeln("<error>{$e->getMessage()}<error>");
        }
    }
}
