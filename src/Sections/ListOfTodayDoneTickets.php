<?php

namespace DailyReporter\Sections;

use DailyReporter\Helper\Jira;
use DailyReporter\Helper\Time;
use DailyReporter\Jira\Client;
use Psr\Container\ContainerInterface;

final class ListOfTodayDoneTickets extends \DailyReporter\Sections\AbstractSection
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

    /**
     * @return array
     */
    public function process(): array
    {
        $data = [];

        $apiResult = $this->client->getWorklog(getenv('JIRA_WORKLOG_USERNAME'), '2017-10-20', '2017-10-20');

        foreach ($apiResult->getResult() as $worklog) {
            $data[] = [
                'ticketId' => $worklog['issue']['key'],
                'ticketName' => $worklog['issue']['summary'],
                'timeSpent' => Time::convertSecondsIntoStringWithHour($worklog['timeSpentSeconds']),
                'comment' => $worklog['comment'],
                'ticketUrl' => Jira::getTicketUrl($worklog['issue']['key'])
            ];
        }

        $this->showDataResult($data);

        return ['doneTicketsList' => $data];
    }

    /**
     * @param array $data
     * @return void
     */
    private function showDataResult(array $data)
    {
        $this->io->table(['Jira Ticket Id', 'Ticket Name', 'Time spent', 'Comment'], $data);
    }
}