<?php

namespace DailyReporter\Api\Core;

use DailyReporter\Exception\ReportCanNotBeBuilded;
use DailyReporter\Report\AbstractReport;

interface ReportInterface
{
    /**
     * @return mixed
     * @throws ReportCanNotBeBuilded
     */
    public function build(): ReportInterface;

    /**
     * @return array
     */
    public function getData(): array;

    /**
     * @return string
     */
    public function getTemplate(): string;

    /**
     * @return string
     */
    public function getSubject(): string;
}