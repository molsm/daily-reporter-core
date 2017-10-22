<?php

namespace DailyReporter\Sections;

use DailyReporter\Helper\Jira;
use DailyReporter\Jira\Client;
use DailyReporter\Sections\AbstractSection as Section;
use Psr\Container\ContainerInterface;
use DailyReporter\Validator\JiraTicket as JiraTicketValidator;

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
            $ticketId = $this->io->ask('Provide ticket Id / Key', null, new JiraTicketValidator);
            $apiResult = $this->client->getTicket($ticketId);
            $ticket = $apiResult->getResult();
            $data[] = [
                'ticketId' => $ticket['key'],
                'ticketName' => $ticket['fields']['summary'],
                'ticketUrl' => Jira::getTicketUrl($ticket['key'])
            ];

            $this->io->title('Current pending tickets');
            $this->showData($data);

            $continue = $this->io->confirm('Add more?', true);
        }

        return ['pendingTasks' => $data];
    }

    /**
     * @param array $data
     */
    private function showData(array $data)
    {
        $this->io->table(
            ['Ticket Id', 'Ticket name', 'Ticket URL'],
            $data
        );
    }
}