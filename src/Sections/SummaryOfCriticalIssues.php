<?php

namespace DailyReporter\Sections;


use DailyReporter\Api\Core\SectionInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SummaryOfCriticalIssues implements SectionInterface
{
    /**
     * @var SymfonyStyle
     */
    private $io;

    public function __construct(ContainerInterface $container)
    {
        $this->io = $container->get('io');
    }

    public function getSectionName(): string
    {
        return 'Summary of critical issue';
    }

    public function process(): array
    {
        $ticketId = $this->io->ask('Enter Jira ticket Id', null);

        return ['ticket_id' => $ticketId];
    }
}