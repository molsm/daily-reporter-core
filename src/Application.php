<?php

namespace DailyReporter;

use DailyReporter\Command\GenerateCommand;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Application
{
    /** @var  ContainerBuilder $container */
    private $container;

    /** @var  ConsoleApplication $consoleAppliction */
    private $consoleApplication;

    public function run()
    {
        $this->registerContainers();
        $this->bootstrapConsoleApllication();
        $this->registerCommands();

        return $this->consoleApplication->run();
    }

    /**
     * @return void
     */
    private function registerContainers()
    {
        $this->container = new ContainerBuilder();
        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/../app/config'));
        $loader->load('services.yml');
        $this->container->compile();
    }

    private function bootstrapConsoleApllication()
    {
        $this->consoleApplication = new ConsoleApplication();
    }

    /**
     * @return void
     */
    private function registerCommands()
    {
        $commands = [
            GenerateCommand::class
        ];

        foreach ($commands as $command) {
            /** @var Command $command */
            $command = $this->container->get($command);
            $this->consoleApplication->add($command);
        }
    }
}