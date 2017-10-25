<?php

namespace DailyReporter\Validator;

class JiraTicket
{
    /**
     * @param $input
     * @return mixed
     * @throws \RuntimeException
     */
    public function __invoke($input)
    {
        if (!$input) {
            throw new \RuntimeException('Ticket Id can not be empty');
        }

        if (preg_match('/[a-zA-Z]*-[0-9]/', $input)) {
            throw new \RuntimeException('Jira ticket ID is not valid');
        }

        return $input;
    }
}