<?php

namespace DailyReporter\Jira;

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;
use chobie\Jira\Api\Result;
use DailyReporter\Api\Jira\ClientInterface;

class Client implements ClientInterface
{
    private $connection;

    public function __construct()
    {
        $this->connection = new Api(
            getenv('JIRA_HOST'),
            new Basic(getenv('JIRA_USERNAME'), getenv('JIRA_PASSWORD'))
        );
    }

    public function getTicket(string $ticketId)
    {
        return $this->connection->getIssue($ticketId);
    }

    /**
     * @param string $username
     * @param string $dateFrom
     * @param string $dateTo
     * @return Result
     */
    public function getWorklog(string $username, string $dateFrom, string $dateTo): Result
    {
        return $this->connection->api($this->connection::REQUEST_GET, static::API_ENDPOINT_URL, [
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'username' => $username
        ]);
    }
}