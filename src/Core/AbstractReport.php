<?php

namespace DailyReporter\Core;

use DailyReporter\Api\Core\ReportInterface;
use DailyReporter\Api\Core\SectionInterface;
use DailyReporter\Exception\ReportCanNotBeFinished;
use DailyReporter\Exception\ReportIsNoValid;
use Psr\Container\ContainerInterface;

abstract class AbstractReport implements ReportInterface
{
    protected $sections = [];

    private $data = [];

    protected $template;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @return AbstractReport
     * @throws ReportCanNotBeFinished
     */
    public function finish(): AbstractReport
    {
        if (!$this->template) {
            throw new ReportCanNotBeFinished('Template is not set');
        }

        return $this;
    }

    /**
     * @return AbstractReport
     */
    public function build(): AbstractReport
    {
        /** @var SectionInterface $section */
        foreach ($this->sections as $section) {
            $section = $this->container->get($section);
            $this->container->get('io')->section($section->getSectionName());
            $this->data[] = $section->process();
        }

        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }
}