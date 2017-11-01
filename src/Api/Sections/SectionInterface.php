<?php

namespace DailyReporter\Api\Sections;

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

    /**
     * @return array
     */
    public function getData(): array;
}