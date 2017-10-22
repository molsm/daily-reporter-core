<?php

namespace DailyReporter\Api;

use DailyReporter\Api\Core\ReportInterface;

interface MailerInterface
{
    public function send(ReportInterface $report);
}