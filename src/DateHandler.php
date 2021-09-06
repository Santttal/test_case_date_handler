<?php

namespace TestCaseDateHandler;

use DateTime;
use Traversable;

class DateHandler implements IDateHandler
{
    /**
     * @param CalendarDatePeriod[] $periods
     * @return DateTime[]|Traversable
     */
    public function convertToDates(array $periods): Traversable
    {
        // @todo add interval overlap validation if needed

        $allowPeriods = $this->filterPeriodsByAction($periods, DatePeriodActionEnum::ACTION_ALLOW);
        $forbidPeriods = $this->filterPeriodsByAction($periods, DatePeriodActionEnum::ACTION_FORBID);

        $forbidDatesWithPriority = $this->mergePeriodsAsMap($forbidPeriods);
        $allowDatesWithPriority = $this->mergePeriodsAsMap($allowPeriods);

        $calculatedDates = $this->calculateDatesDiff($allowDatesWithPriority, $forbidDatesWithPriority);
        $calculatedDates = array_keys($calculatedDates);

        foreach ($calculatedDates as $date) {
            yield new DateTime($date);
        }
    }

    /**
     * @param CalendarDatePeriod[] $period
     * @return CalendarDatePeriod[]
     */
    private function filterPeriodsByAction(array $period, string $action): array
    {
        return array_filter($period, static fn(CalendarDatePeriod $period): bool => $period->getAction() === $action);
    }

    /**
     * @param CalendarDatePeriod[] $periods
     * @return int[]
     */
    private function mergePeriodsAsMap(array $periods): array
    {
        $dates = [];
        foreach ($periods as $period) {
            $dates[] = $period->convertToDateAndPriorityMap();
        }

        return array_merge(...$dates);
    }

    /**
     * @param int[] $allowDatesWithPriority
     * @param int[] $forbidDatesWithPriority
     * @return int[]
     */
    private function calculateDatesDiff(array $allowDatesWithPriority, array $forbidDatesWithPriority): array
    {
        foreach ($allowDatesWithPriority as $allowDate => $allowPriority) {
            if (array_key_exists($allowDate, $forbidDatesWithPriority)) {
                $forbidPriority = $forbidDatesWithPriority[$allowDate];
                if ($forbidPriority >= $allowPriority) {
                    unset($allowDatesWithPriority[$allowDate]);
                }
            }
        }

        return $allowDatesWithPriority;
    }
}
