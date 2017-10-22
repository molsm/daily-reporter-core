<?php

namespace DailyReporter;

use DailyReporter\Api\ConfigInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class Config implements ConfigInterface
{
    private $config;
    private $reports;
    private $commands;

    /**
     * @var FileLocator
     */
    private $fileLocator;

    public function __construct($file = null)
    {
        $this->config = Yaml::parse(file_get_contents($file));

        foreach ($this->config as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function getReports(): array
    {
        return $this->reports;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }
}