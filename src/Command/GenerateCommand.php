<?php

namespace DailyReporter\Command;

use App\Report\GenericTwo;
use DailyReporter\Api\ConfigInterface;
use DailyReporter\Mailer;
use DailyReporter\Report\Generic;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GenerateCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Generic
     */
    private $generic;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var ConfigInterface
     */
    private $config;

    public function __construct(GenericTwo $generic, ContainerInterface $container, Mailer $mailer)
    {
        parent::__construct();
        $this->container = $container;
        $this->generic = $generic;
        $this->mailer = $mailer;
        $this->config = $container->get(ConfigInterface::class);
    }

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('generate')->setDescription('Generate report');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyStyle = new SymfonyStyle($input, $output);
        $this->container->set('io', $symfonyStyle);

        $this->generic->build();
        $report = $this->generic->finish();
        $this->mailer->send($report);
    }
}