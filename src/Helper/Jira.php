<?php

namespace DailyReporter\Helper;

class Jira
{
    /**
     * @param $ticketKey
     * @return string
     */
    public static function getTicketUrl($ticketKey)
    {
        if (substr(getenv('JIRA_HOST'), -1 ) === '/') {
            return getenv('JIRA_HOST').sprintf('browse/%s', $ticketKey);
        } else {
            return getenv('JIRA_HOST').'/'.sprintf('browse/%s', $ticketKey);
        }
    }
}