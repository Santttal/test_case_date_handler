<?php

namespace TestCaseDateHandler;

use DateTime;
use Traversable;

interface IDateHandler
{
    /**
     * @param CalendarDatePeriod[] $periods
     * @return DateTime[]|Traversable
     */
    public function convertToDates(array $periods): Traversable;
}
