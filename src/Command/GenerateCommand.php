<?php

namespace DailyReporter\Command;

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;
use DailyReporter\Mailer;
use DailyReporter\Report\Generic;
use DailyReporter\Report\GenericFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GenerateCommand extends Command
{
    /**
     * @var GenericFactory
     */
    private $reportGenericFactory;
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

    public function __construct(Generic $generic, ContainerInterface $container, Mailer $mailer)
    {
        parent::__construct();
        $this->container = $container;
        $this->generic = $generic;
        $this->mailer = $mailer;
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