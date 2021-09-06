<?php

use TestCaseDateHandler\CalendarDatePeriod;
use TestCaseDateHandler\DateHandler;
use TestCaseDateHandler\DatePeriodActionEnum;
use TestCaseDateHandler\DatePeriodPriorityEnum;

require_once __DIR__ . '/../vendor/autoload.php';

$intervals = [
    CalendarDatePeriod::create('2021-01-01', '2021-01-10', DatePeriodPriorityEnum::PRIORITY_NORMAL, DatePeriodActionEnum::ACTION_ALLOW),
    CalendarDatePeriod::create('2021-05-15', '2021-05-30', DatePeriodPriorityEnum::PRIORITY_NORMAL, DatePeriodActionEnum::ACTION_ALLOW),
    CalendarDatePeriod::create('2021-05-10', '2021-05-17', DatePeriodPriorityEnum::PRIORITY_NORMAL, DatePeriodActionEnum::ACTION_FORBID),
    CalendarDatePeriod::create('2021-05-16', '2021-06-05', DatePeriodPriorityEnum::PRIORITY_HIGH, DatePeriodActionEnum::ACTION_FORBID),
];


$handler = new DateHandler();
$dates = iterator_to_array($handler->convertToDates($intervals));

foreach ($dates as $date) {
    echo $date->format('Y-m-d') . PHP_EOL;
}

