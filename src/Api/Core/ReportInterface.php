<?php

namespace DailyReporter\Api\Core;

use DailyReporter\Core\AbstractReport;

interface ReportInterface
{
    /**
     * @return void
     */
    public function finish();

    /**
     * @param $key
     * @param $value
     * @return AbstractReport
     */
    public function setParts($key, $value): AbstractReport;
}