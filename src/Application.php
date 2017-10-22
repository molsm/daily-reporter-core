<?php

namespace DailyReporter;

use DailyReporter\Api\ConfigInterface;
use DailyReporter\Command\GenerateCommand;
use DailyReporter\Core\Template;
use DailyReporter\Report\Collection;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\Yaml\Yaml;
use Twig_Environment;
use Twig_Loader_Filesystem;

class Application
{
    /** @var  ContainerBuilder $container */
    private $container;

    /** @var  ConsoleApplication $consoleAppliction */
    private $consoleApplication;

    public function run()
    {
        $this->registerServiceProviders();
        $this->bootstrapConsoleApplication();
        $this->registerCommands();

        return $this->consoleApplication->run();
    }

    /**
     * @return void
     */
    private function registerServiceProviders()
    {
        $this->container = new ContainerBuilder();

        $loader = new YamlFileLoader($this->container, new FileLocator(__DIR__.'/config'));
        $loader->load('services.yml');
        $this->container->compile();

        $template = new Twig_Environment(new Twig_Loader_Filesystem(__DIR__.'/../resources/views'));
        $this->container->set('template', $template);

        $dotenv = new Dotenv();
        $dotenv->load(__DIR__.'/../.env');

        $config = new Config(__DIR__.'/../config.yml');
        $this->container->set(ConfigInterface::class, $config);
    }

    /**
     * @return void
     */
    private function bootstrapConsoleApplication()
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