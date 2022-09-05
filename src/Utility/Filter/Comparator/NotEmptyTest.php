<?php


namespace NoLoCo\Core\Utility\Filter\Comparator;


class NotEmptyTest implements ArrayTestInterface, ScalarTestInterface
{
    /**
     * @inheritDoc
     */
    public function testArray(array $actual): bool
    {
        return !empty($actual);
    }

    /**
     * @inheritDoc
     */
    public function testScalar($actual): bool
    {
        return !empty($actual);
    }
}