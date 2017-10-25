<?php

namespace DailyReporter\Sections;

use DailyReporter\Api\Sections\SectionInterface;
use DailyReporter\Jira\Client;
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
     * @var Client
     */
    protected $client;

    /**
     * AbstractSection constructor.
     * @param ContainerInterface $container
     * @param Client $client
     */
    public function __construct(ContainerInterface $container, Client $client)
    {
        $this->io = $container->get('io');
        $this->client = $client;
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
     * @param array $after
     * @return void
     */
    protected function triggerDataManipulationChoose(array $after)
    {
        $result = $this->io->choice(
            'Choose and option',
            [static::CHOISE_REMOVE_RECORD,static::CHOISE_ADD_RECORD, static::CHOISE_CONTINUE],
            static::CHOISE_CONTINUE
        );
        call_user_func($after, $result);
    }

    protected function showResult()
    {

    }
}