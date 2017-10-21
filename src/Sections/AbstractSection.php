<?php

namespace DailyReporter\Sections;

use DailyReporter\Api\Sections\SectionInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use DailyReporter\Exception\ReportCanNotBeBuilded;

class AbstractSection implements SectionInterface
{
    /**
     * @var SymfonyStyle
     */
    protected $io;

    protected $sectionName;

    /**
     * AbstractSection constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->io = $container->get('io');
    }

    /**
     * @return array
     * @throws ReportCanNotBeBuilded
     */
    public function process(): array
    {
        throw new ReportCanNotBeBuilded('Section process is not implemented');
    }

    /**
     * @return string
     * @throws ReportCanNotBeBuilded
     */
    public function getSectionName(): string
    {
        if (!$this->sectionName) {
            throw new ReportCanNotBeBuilded('Section name is not defined');
        }

        return $this->sectionName;
    }
}