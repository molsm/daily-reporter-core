<?php

namespace DailyReporter\Report;

use DailyReporter\Api\Core\ReportInterface;
use DailyReporter\Api\Sections\SectionInterface;
use DailyReporter\Exception\ReportCanNotBeBuilded;
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
     * @var string
     */
    protected $template;

    /**
     * @var string
     */
    protected $subject;

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
     * @return ReportInterface
     * @throws ReportCanNotBeBuilded
     */
    public function build(): ReportInterface
    {
        if (!$this->template) {
            throw new ReportCanNotBeBuilded('Template is not set');
        }

        if (!$this->getSubject()) {
            throw new ReportCanNotBeBuilded('Subject is empty');
        }

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

    public function getSubject(): string
    {
        return $this->subject;
    }
}