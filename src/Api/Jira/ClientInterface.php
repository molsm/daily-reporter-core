<?php

namespace DailyReporter\Api\Jira;

use chobie\Jira\Api\Result;

interface ClientInterface
{
    const API_ENDPOINT_URL = '/rest/tempo-timesheets/3/worklogs/';

    /**
     * @param string $ticketIdOrKey
     * @return array
     */
    public function getTicket(string $ticketIdOrKey): array;

    /**
     * @param string $username
     * @param string $dateFrom
     * @param string $dateTo
     * @return Result
     */
    public function getWorklog(string $username, string $dateFrom, string $dateTo): Result;
}