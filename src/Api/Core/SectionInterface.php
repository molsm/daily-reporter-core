<?php

namespace DailyReporter\Api\Core;

interface SectionInterface
{
    /**
     * @return string
     */
    public function getSectionName(): string;

    /**
     * @return array
     */
    public function process(): array;
}