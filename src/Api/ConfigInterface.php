<?php

namespace DailyReporter\Api;

interface ConfigInterface
{
    /**
     * @return array
     */
    public function getReports(): array;

    /**
     * @return array
     */
    public function getCommands(): array;
}