<?php

namespace UCS\Component\TimeSheet\Tests\Rules;

use UCS\Component\TimeSheet\Rules\AbstractEntriesBuilder;
use UCS\Component\TimeSheet\Rules\SameWeekRule;
use UCS\Component\TimeSheet\Validator\TimeSheetValidationContext;

/**
 * Class SameWeekRuleTest
 */
class SameWeekRuleTest extends \PHPUnit_Framework_TestCase
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
     * @var SameWeekRule
     */
    private $sameWeekRule;

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

        $this->sameWeekRule = new SameWeekRule('oW');
    }

    /**
     * test name rule
     */
    public function testGetName()
    {
        $this->assertEquals('SameWeek', $this->sameWeekRule->getName());
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

        $this->assertEquals(true,  $this->sameWeekRule->validate($this->validationContext));
    }

    /**
     * @return array
     */
    private function buildEntries()
    {
        $fisrtEntry = new \DateTime('2018-03-13');
        $secondEntry = new \DateTime('2018-03-15');

        return [
            $fisrtEntry,
            $secondEntry,
        ];
    }
}
