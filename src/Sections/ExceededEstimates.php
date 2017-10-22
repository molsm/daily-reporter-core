<?php

namespace DailyReporter\Sections;

use DailyReporter\Sections\AbstractSection as Section;

class ExceededEstimates extends Section
{
    protected $sectionName = 'Exceeded estimates';

    /**
     * @return array
     */
    public function process(): array
    {
        $data = [];

        $data[] = $this->io->ask('Write exceeded estimate', 'n/a');

        return ['exceededEstimates' => $data];
    }
}