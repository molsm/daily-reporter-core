<?php

namespace DailyReporter\Validator;

class JiraTicket
{
    public function __invoke($input)
    {
        if (!$input) {
            throw new \RuntimeException('Ticket Id can not be empty');
        }

        if (preg_match('((?<!([A-Z]{1,10})-?)[A-Z]+-\d+)', $input)) {
            throw new \RuntimeException('Jira ticket ID is not valid');
        }

        return $input;
    }
}