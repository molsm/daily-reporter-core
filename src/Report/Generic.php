<?php

namespace DailyReporter\Report;

use DailyReporter\Core\AbstractReport;
use DailyReporter\Sections\ExceededEstimates;
use DailyReporter\Sections\InputFromPmClientRequired;
use DailyReporter\Sections\ListOfTodayDoneTickets;
use DailyReporter\Sections\PendingTasks;
use DailyReporter\Sections\SummaryOfCriticalIssues;

class Generic extends AbstractReport
{
    protected $template = 'generic.html.twig';

    protected $sections = [
//        SummaryOfCriticalIssues::class,
        ListOfTodayDoneTickets::class,
//        ExceededEstimates::class,
//        PendingTasks::class,
//        InputFromPmClientRequired::class
    ];
}