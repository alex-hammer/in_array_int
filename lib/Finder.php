<?php

class Finder
{
    private int $needle = 0;
    private array $haystack = [];

    public function __construct(int $needle, array $haystack)
    {
        $this->needle = $needle;
        $this->haystack = $haystack;
    }

    public function inArrayBinary(): bool
    {
        $left = 0;
        $right = count($this->haystack) -1;

        while ($left <= $right) {

            $mid = (($left + $right) >> 1);

            if ($this->needle === $this->haystack[$mid]) {
                return true;
            }
            if ($this->needle < $this->haystack[$mid]) {
                $right = $mid - 1;
            } else {
                $left = $mid + 1;
            }
        }

        return ($this->haystack[$left] === $this->needle);
    }

    public function inArrayInterpolation(): bool
    {
        $left = 0;
        $right = count($this->haystack) -1;

        while ($this->haystack[$left] <= $this->needle && $this->haystack[$right] >= $this->needle) {

            $mid = $left + floor(
                    ($this->needle - $this->haystack[$left])
                    * ($right - $left) / ($this->haystack[$right] - $this->haystack[$left])
                );

            if ($this->needle === $this->haystack[$mid]) {
                return true;
            }
            if ($this->needle < $this->haystack[$mid]) {
                $right = $mid - 1;
            } else {
                $left = $mid + 1;
            }
        }

        return ($this->haystack[$left] === $this->needle);
    }

    public function inArrayNative(): bool
    {
        return in_array($this->needle, $this->haystack, true);
    }
}
