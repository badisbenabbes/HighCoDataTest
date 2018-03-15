<?php

namespace UCS\Component\TimeSheet\Rules;

use UCS\Component\TimeSheet\TimeEntryInterface;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationRuleInterface;

/**
 * Class SameWeekRule
 */
class SameWeekRule extends AbstractEntriesBuilder implements TimeSheetValidationRuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SameWeek';
    }

    /**
     * {@inheritdoc}
     */
    public function validate(TimeSheetValidationContext $validationContext)
    {
        /** @var TimeEntryInterface[] $entries */
        $entries = $validationContext->getTimeSheet()->getEntries();
        $this->mask = 'oW';

        if (!$this->isSameInterval($entries)) {
            $validationContext->addViolation('The dates entered must belonging to the same week');

            return false;
        }

        return true;
    }
}
