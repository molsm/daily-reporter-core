<?php

namespace DailyReporter\Command;

use DailyReporter\Api\Core\BuildInterface;
use DailyReporter\Core\Template;
use DailyReporter\Report\GenericFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GenerateCommand extends Command
{
    /**
     * @var GenericFactory
     */
    private $reportGenericFactory;

    public function __construct(GenericFactory $reportGenericFactory)
    {
        parent::__construct();
        $this->reportGenericFactory = $reportGenericFactory;
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
        $genericReport = $this->reportGenericFactory->create();
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $io = new SymfonyStyle($input, $output);

        $io->section('Hello');

        $io->ask('Number of workers to start', null, function ($number) {
            return $number;
        });

//        foreach ($genericReport->getQuestions() as $questionId => $questionData) {
//            $question = new Question($questionData['question'], $questionData['default']);
//            $answer = $helper->ask($input, $output, $question);
//
//            $genericReport->setParts($questionId, $answer);
//        }
    }
}