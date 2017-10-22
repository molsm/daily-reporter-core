<?php

namespace DailyReporter\Sections;

use DailyReporter\Jira\Client;
use DailyReporter\Sections\AbstractSection as Section;
use Psr\Container\ContainerInterface;

class PendingTasks extends Section
{
    protected $sectionName = 'Pending tasks';

    /**
     * @var Client
     */
    private $client;

    /**
     * PendingTasks constructor.
     * @param ContainerInterface $container
     * @param Client $client
     */
    public function __construct(ContainerInterface $container, Client $client)
    {
        parent::__construct($container);
        $this->client = $client;
    }

    /**
     * @return array
     */
    public function process(): array
    {
        $data = [];
        $continue = true;

        while ($continue) {
            $data[] = $this->io->ask('Provide ticket Id', null);
            $continue = $this->io->confirm('Add more?', true);
        }

        return ['pendingTasks' => $data];
    }
}