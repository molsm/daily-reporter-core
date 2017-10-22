<?php

namespace DailyReporter\Api\Core;

use DailyReporter\Report\AbstractReport;

interface ReportInterface
{
    /**
     * @return mixed
     */
    public function build(): AbstractReport;

    /**
     * @return AbstractReport
     */
    public function finish(): AbstractReport;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return string
     */
    public function getTemplate(): string;
}