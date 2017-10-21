<?php

namespace DailyReporter\Core;

use DailyReporter\Api\Core\ReportInterface;
use DailyReporter\Exception\ReportCanNotBeFinished;
use DailyReporter\Exception\ReportIsNoValid;

abstract class AbstractReport implements ReportInterface
{
    /**
     * @var array
     */
    private $parts = [];

    /**
     * @var array
     */
    protected $requiredParts = [];

    /**
     * @throws ReportCanNotBeFinished
     */
    public function finish()
    {
        if (empty($requiredParts)) {
            throw new ReportCanNotBeFinished('Required parts is not defined');
        }

        foreach ($requiredParts as $part) {
            if (!array_key_exists($part, $this->parts)) {
                throw new ReportCanNotBeFinished('Not all report parts has been provided');
            }
        }
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setParts($key, $value): AbstractReport
    {
        $this->data[$key] = $value;
        return $this;
    }
}