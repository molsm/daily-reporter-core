<?php

namespace DailyReporter\Validator;

class JiraTicket
{
    public function __invoke($input)
    {
        if (!$input) {
            throw new \RuntimeException('Ticket Id can not be empty');
        }

        return $input;
    }
}