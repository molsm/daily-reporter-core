<?php

namespace DailyReporter\Helper;

class Time
{
    public static function convertSecondsIntoStringWithHour($seconds)
    {
        return sprintf('%sh',$seconds / 3600);
    }
}