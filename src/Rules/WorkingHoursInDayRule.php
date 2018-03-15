<?php

namespace UCS\Component\TimeSheet\Rules;

use UCS\Component\TimeSheet\TimeEntryInterface;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationRuleInterface;

/**
 * Class WorkingHoursInDayRule
 */
class WorkingHoursInDayRule extends AbstractEntriesBuilder implements TimeSheetValidationRuleInterface
{
    /**
     * @var int
     */
    const MAX_DURATION = 8;

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'WorkingHoursInDayRule';
    }

    /**
     * {@inheritdoc}
     */
    public function validate(TimeSheetValidationContext $validationContext)
    {
        $entriesDuration = 0;
        $this->mask = 'oz';
        /** @var TimeEntryInterface[] $timeEntries */
        $timeEntries = $validationContext->getTimeSheet()->getEntries();

        foreach ($timeEntries as $timeEntry) {
            // count all duration entries
            $entriesDuration += $timeEntry->getDuration();
        }
        // check if day is differents
        if (!$this->isSameInterval($timeEntries)) {
            $validationContext->addViolation('The dates entered are different');

            return false;
        }
        if ($entriesDuration > self::MAX_DURATION) {
            $validationContext->addViolation('Can not enter more than '.self::MAX_DURATION.' hours of work in a single day');

            return false;
        }

        return true;
    }
}
