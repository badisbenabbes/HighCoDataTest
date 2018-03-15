<?php

namespace UCS\Component\TimeSheet\Rules;

use UCS\Component\TimeSheet\TimeEntryInterface;

/**
 * Class AbstractEntriesBuilder
 */
class AbstractEntriesBuilder
{
    /**
     * @var string
     */
    protected $mask;

    /**
     * AbstractEntriesBuilder constructor.
     *
     * @param $mask
     */
    public function __construct($mask)
    {
        $this->mask = $mask;
    }

    /**
     * @param TimeEntryInterface[] $entries
     *
     * @return bool
     */
    protected function isSameInterval(array $entries)
    {
        $entries = array_map(
            function ($value) {
                /** @var \DateTime $value */
                return $value->format($this->mask);
            },
            $entries
        );

        //check if all entries are the same interval
        return 1 == count(array_unique($entries));
    }
}
