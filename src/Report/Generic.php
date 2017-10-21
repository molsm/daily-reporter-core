<?php

namespace DailyReporter\Report;

use DailyReporter\Core\AbstractReport;
use DailyReporter\Sections\ListOfTodayDoneTickets;
use DailyReporter\Sections\SummaryOfCriticalIssues;

class Generic extends AbstractReport
{
    protected $template = 'generic.html.twig';

    protected $sections = [
        ListOfTodayDoneTickets::class
    ];
}