<?php

namespace TestCaseDateHandler;

use DateInterval;
use DatePeriod;
use DateTime;

class CalendarDatePeriod
{
    private DatePeriod $period;
    private int $priority;
    private string $action;

    private function __construct(DatePeriod $period, int $priority, string $action)
    {
        $this->period = $period;
        $this->priority = $priority;
        $this->action = $action;
    }

    public static function create(string $startDate, string $endDate, int $priority, string $action): self
    {
        // @todo add params validation if needed

        $period = new DatePeriod(
            new DateTime($startDate . ' 00:00:00'),
            new DateInterval('P1D'),
            new DateTime($endDate . ' 23:59:59'),
        );

        return new static($period, $priority, $action);
    }

    /**
     * @return string[]
     */
    public function convertToDateAndPriorityMap(): array
    {
        $result = [];

        foreach ($this->period as $date) {
            $result[$date->format('Y-m-d')] = $this->priority;
        }

        return $result;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}
