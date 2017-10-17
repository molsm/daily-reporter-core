<?php

namespace DailyReporter;

use DailyReporter\Command\GenerateCommand;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends ConsoleApplication
{
    /**
     * @param InputInterface|null $input
     * @param OutputInterface|null $output
     * @return int
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        $this->registerCommands();

        return parent::run($input, $output);
    }

    /**
     * @return void
     */
    private function registerCommands()
    {
        $this->add(new GenerateCommand());
    }
}