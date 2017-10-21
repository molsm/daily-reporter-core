<?php

namespace DailyReporter\Sections;

use DailyReporter\Validator\JiraTicket as JiraTicketValidator;

class SummaryOfCriticalIssues extends AbstractSection
{
    protected $sectionName = 'Summary of critical issue';

    /**
     * @return array
     */
    public function process(): array
    {
        $result = [];
        $continue = true;

        if ($this->io->confirm('Do you have critical issues?', false)) {
            while ($continue) {
                $result[] = $this->io->ask('Enter Jira ticket Id', null, new JiraTicketValidator);
                $continue = $this->io->confirm('One more?', false);
            }
        }

        return $result;
    }
}