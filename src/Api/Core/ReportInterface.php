<?php

namespace DailyReporter\Api\Core;

interface ReportInterface
{
    /**
     * @return void
     */
    public function finish();

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setParts($key, $value);

    public function getQuestions();
}