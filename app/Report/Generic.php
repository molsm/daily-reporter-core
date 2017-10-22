<?php

namespace App\Report;

use DailyReporter\Report\AbstractReport;
use App\Sections\ExceededEstimates;
use App\Sections\InputFromPmClientRequired;
use App\Sections\ListOfTodayDoneTickets;
use App\Sections\PendingTasks;
use App\Sections\SummaryOfCriticalIssues;

class Generic extends AbstractReport
{
    protected $template = 'generic.html.twig';

    protected $subject = 'Worklog report';

    protected $sections = [
        SummaryOfCriticalIssues::class,
        ListOfTodayDoneTickets::class,
        ExceededEstimates::class,
        PendingTasks::class,
        InputFromPmClientRequired::class
    ];
}