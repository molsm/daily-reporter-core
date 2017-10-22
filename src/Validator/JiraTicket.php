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
        // TODO: Implment preg_match
//        if (preg_match('/((?<!([A-Z]{1,10})-?)[A-Z]+-\d+)/', $input)) {
//            throw new \RuntimeException('Jira ticket ID is not valid');
//        }

        return $input;
    }
}