<?php

namespace DailyReporter\Sections;

use DailyReporter\Api\Sections\SectionInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use DailyReporter\Exception\ReportCanNotBeBuilded;

abstract class AbstractSection implements SectionInterface
{
    const CHOISE_REMOVE_RECORD = 'Remove record';
    const CHOISE_ADD_RECORD = 'Add record';
    const CHOISE_CONTINUE = 'Continue';

    /**
     * @var SymfonyStyle
     */
    protected $io;

    /**
     * Defined section name will be shown in console output
     * @var string
     */
    protected $sectionName;

    /**
     * Section data
     * @var array
     */
    protected $data = [];

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

    /**
     * @param callable $after
     * @return void
     */
    protected function triggerDataManipulationChoose(callable $after)
    {
        $result = $this->io->choice(
            'Choose and option',
            [static::CHOISE_REMOVE_RECORD,static::CHOISE_ADD_RECORD, static::CHOISE_CONTINUE],
            static::CHOISE_CONTINUE
        );
        call_user_func($after, $result);
    }
}