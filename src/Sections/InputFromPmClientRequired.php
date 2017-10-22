<?php

namespace DailyReporter\Sections;

use DailyReporter\Sections\AbstractSection as Section;

class InputFromPmClientRequired extends Section
{
    protected $sectionName = 'Input from PM / Client Required';

    /**
     * @return array
     */
    public function process(): array
    {
        $data = [];

        $data[] = $this->io->ask('Write text', 'n/a');

        return ['inputFromPmOrClient' => $data];
    }
}