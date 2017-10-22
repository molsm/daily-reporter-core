<?php

namespace DailyReporter\Command;

use App\Report\GenericTwo;
use DailyReporter\Api\ConfigInterface;
use DailyReporter\Mailer;
use DailyReporter\Report\Generic;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
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
        $this->setName('generate')->setDescription('Generate report')
            ->addArgument('report', InputArgument::REQUIRED, 'Report code');
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

        $reportCode = $input->getArgument('report');
        $reports = $this->config->getReports();
        if (!isset($reports[$reportCode])) {
            throw new RuntimeException('Report with this code not exists');
        }

        var_dump($this->container->getDefinitions());
        $report = $this->container->get($reports[$reportCode])->build();

        $symfonyStyle->section('Finish');
        if (!$symfonyStyle->confirm(sprintf('Report is builded. Send report to %s', getenv('MAIL_TO')), false)) {
            throw new RuntimeException('Mail send aborted');
        }

        $this->mailer->send($report);
    }
}