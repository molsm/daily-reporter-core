<?php

namespace DailyReporter\Sections;

use DailyReporter\Jira\Client;
use Psr\Container\ContainerInterface;

class ListOfTodayDoneTickets extends AbstractSection
{
    protected $sectionName = 'Done Today';
    /**
     * @var Client
     */
    private $client;

    public function __construct(ContainerInterface $container, Client $client)
    {
        parent::__construct($container);
        $this->client = $client;
    }

    public function process(): array
    {
        $data = [];

        $apiResult = $this->client->getWorklog(getenv('JIRA_WORKLOG_USERNAME'), '2017-10-20', '2017-10-21');

        foreach ($apiResult->getResult() as $worklog) {
            var_dump($worklog['comment']);
        }

        return $data;
    }
}