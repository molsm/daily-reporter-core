<?php

namespace DailyReporter\Report;

class GenericFactory
{
    /**
     * @return Generic
     */
    public function create(): Generic
    {
        return new Generic();
    }
}