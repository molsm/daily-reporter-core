<?php

namespace DailyReporter\Report;

use DailyReporter\Api\Core\ReportInterface;
use DailyReporter\Api\Sections\SectionInterface;
use DailyReporter\Exception\ReportCanNotBeFinished;
use DailyReporter\Exception\ReportIsNoValid;
use Psr\Container\ContainerInterface;

abstract class AbstractReport implements ReportInterface
{
    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @var
     */
    protected $template;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * AbstractReport constructor.
     * @param ContainerInterface $container
     */
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
            $this->data = array_merge($this->data, $section->process());
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }
}