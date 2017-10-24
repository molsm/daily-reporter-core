<?php

namespace DailyReporter\Jira;

use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;
use chobie\Jira\Api\Result;
use DailyReporter\Api\Jira\ClientInterface;
use DailyReporter\Exception\CanNotRetrieveDataFromJira;

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

    /**
     * @param string $ticketId
     * @return Result|false
     * @throws CanNotRetrieveDataFromJira
     */
    public function getTicket(string $ticketId)
    {
        $result = $this->connection->getIssue($ticketId)->getResult();

        if (isset($result['errorMessages'])) {
            throw new CanNotRetrieveDataFromJira(implode('. ', $result['errorMessages']));
        }

        return $result;
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