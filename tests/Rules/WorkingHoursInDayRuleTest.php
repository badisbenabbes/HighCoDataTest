<?php

namespace UCS\Component\TimeSheet\Tests\Rules;

use UCS\Component\TimeSheet\Rules\AbstractEntriesBuilder;
use UCS\Component\TimeSheet\Rules\WorkingHoursInDayRule;
use UCS\Component\TimeSheet\TimeEntry;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;


class WorkingHoursInDayRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AbstractEntriesBuilder|\PHPUnit_Framework_MockObject_MockObject
     */
    private $abstractEntriesBuilder;
    /**
     * @var TimeSheetValidationContext|\PHPUnit_Framework_MockObject_MockObject
     */
    private $validationContext;
    /**
     * @var WorkingHoursInDayRule
     */
    private $workingHoursInDayRule;

    /**
     * set up
     */
    public function setup()
    {
        $this->abstractEntriesBuilder = $this->getMockBuilder(AbstractEntriesBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->validationContext = $this->getMockBuilder(TimeSheetValidationContext::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->workingHoursInDayRule = new WorkingHoursInDayRule('oz');
    }

    /**
     * test name rule
     */
    public function testGetName()
    {
        $this->assertEquals('WorkingHoursInDayRule', $this->workingHoursInDayRule->getName());
    }

    /**
     * test validation rule
     */
    public function testValidate()
    {
        $entries = $this->buildEntries();

        $this->abstractEntriesBuilder
            ->expects($this->any())
            ->method('isSameInterval')
            ->with($entries)
            ->willReturn(true);

        $this->validationContext
            ->expects($this->any())
            ->method('getDuration')
            ->willReturn($this->buildDuration());

        $this->assertEquals(true,  $this->workingHoursInDayRule->validate($this->validationContext));
    }

    /**
     * @return array
     */
    private function buildEntries()
    {
        $fisrtEntry = new \DateTime('2018-03-15');
        $secondEntry = new \DateTime('2018-03-15');

        return [
            $fisrtEntry,
            $secondEntry,
        ];
    }

    /**
     * @return array
     */
    private function buildDuration()
    {
        $timeEntry = new TimeEntry();

        $entries = $this->buildEntries();
        $timeEntry->setDuration(2);
        $timeEntrySecond = clone $timeEntry;
        $timeEntrySecond->setDuration(3);

        $entries[0] = $timeEntry;
        $entries[1] = $timeEntrySecond;

        return $entries;
    }
}
