<?php

namespace DailyReporter\Helper;

class Jira
{
    /**
     * @param $ticketKey
     * @return string
     */
    public static function getTicketUrl($ticketKey): string
    {
        if (substr(getenv('JIRA_HOST'), -1 ) === '/') {
            return getenv('JIRA_HOST').sprintf('browse/%s', $ticketKey);
        } else {
            return getenv('JIRA_HOST').'/'.sprintf('browse/%s', $ticketKey);
        }
    }

    /**
     * @param $originalEstimateSeconds
     * @param $timeSpentSeconds
     * @return int
     */
    public static function getTicketExceededTimeInSeconds($originalEstimateSeconds, $timeSpentSeconds): int
    {
        $exceededTime = $originalEstimateSeconds - $timeSpentSeconds;

        return $exceededTime < 0 ? abs($exceededTime) : 0;
    }


    /**
     * @param $originalEstimateSeconds
     * @param $timeSpentSeconds
     * @return int
     */
    public static function getTicketPendingTimeInSeconds($originalEstimateSeconds, $timeSpentSeconds): int
    {
        $pendingTime = $originalEstimateSeconds - $timeSpentSeconds;

        return $pendingTime > 0 ? $pendingTime : 0;
    }
}