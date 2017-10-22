<?php

namespace DailyReporter;

use DailyReporter\Api\ConfigInterface;
use Symfony\Component\Yaml\Yaml;

class Config implements ConfigInterface
{
    /**
     * @var mixed
     */
    private $config;

    /**
     * @var
     */
    private $reports;

    /**
     * @var
     */
    private $commands;

    /**
     * Config constructor.
     * @param null $file
     */
    public function __construct($file = null)
    {
        $this->config = Yaml::parse(file_get_contents($file));

        foreach ($this->config as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * @return array
     */
    public function getReports(): array
    {
        return $this->reports;
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }
}