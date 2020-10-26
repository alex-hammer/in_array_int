<?php

class RandomArray
{
    private const GENERATE_BY_METHOD = 2;

    private array $array = [];

    public function __construct(int $minInt = 1, int $maxInt = 10 * 1000 * 1000)
    {
        $this->array = static::generateArray($minInt, $maxInt);
    }

    public function getData():  array
    {
        return $this->array;
    }

    private static function generateArray(int $minInt, int $maxInt): array
    {
        return (static::GENERATE_BY_METHOD === 2)
            ? static::generateArray2($minInt, $maxInt)
            : static::generateArray1($minInt, $maxInt);
    }

    private static function generateArray2(int $minInt, int $maxInt): array
    {
        $ints = range($minInt, $maxInt);
        shuffle($ints);
        $howManyLeaveInArray = random_int(2, $maxInt - 1);
        $ints = array_slice($ints, 0, $howManyLeaveInArray);
        sort($ints);

        return $ints;
    }

    private static function generateArray1(int $minInt, int $maxInt): array
    {
        $ints = range($minInt, $maxInt);
        $randKeysOfInts = (array) array_rand(
            $ints,
            random_int(2, $maxInt - 1)
        );

        return array_keys(array_intersect(array_flip($ints), $randKeysOfInts));
    }
}
