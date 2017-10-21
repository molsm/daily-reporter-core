<?php

namespace DailyReporter\Report;

use DailyReporter\Core\AbstractReport;

class Generic extends AbstractReport
{
    protected $requiredParts = [];

    public function getQuestions()
    {
        return [
            'summary_of_critical_issues' => [
                'question' => 'Summary of critical issues? ',
                'default' => 'n/a',
                'with_ticket_id' => false,
            ],
            'to_be_done' => [
                'question' => 'To be done (Enter ticket Id) ',
                'default' => '',
                'with_ticket_id' => true,
            ],
            'exceeded_estimates' => [
                'question' => 'Exceeded estimates: ',
                'default' => '',
                'with_ticket_id' => true,
            ]
        ];
    }
}