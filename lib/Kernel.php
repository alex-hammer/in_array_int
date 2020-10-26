<?php

class Kernel
{
    private const MAX_INT = 10 * 1000 * 1000;
    private const MEASUREMENTS_FOR_EACH_ALGO = 1000;
    private const REGENERATE_EACH_N = 100;

    private array $haystack = [];

    /**
     * @throws Exception
     */
    public function run(): void
    {
        print_r($this->compareAlgorithms());

        echo PHP_EOL . 'Memory peak usage is ' . Tools::formatBytes(memory_get_peak_usage(true)) . PHP_EOL;
    }

    /**
     * @return string[][]
     * @throws Exception
     */
    private function compareAlgorithms(): array
    {
        $finds = [];
        for ($i = 0; $i < self::MEASUREMENTS_FOR_EACH_ALGO; $i++) {
    //        $finds[] = $haystack[array_rand($haystack)]; // 100% happens
    //        $finds[] = -1; // never happens
            $finds[] = random_int(1, self::MAX_INT); // happens sometimes
        }

        $results = array_fill_keys([
            'inArrayInterpolation',
            'inArrayBinary',
    //        'inArrayNative'
        ], 0);

        foreach ($finds as $i => $find) {
            if ($i % self::REGENERATE_EACH_N == 0) {
                $this->setHaystack($i);
            }
            foreach (array_keys($results) as $algoName) {
                $finder = new Finder($find, $this->haystack);
                $results[$algoName] += $this->getAverageTimeForAlgorithm([$finder, $algoName]);
            }
        }

        echo 'Done.' . PHP_EOL;

        return array_map(
            fn($item) => [
                'Total execution time: ' . Tools::formatSeconds($item),
                'Avg execution time: ' . Tools::formatSeconds($item / self::MEASUREMENTS_FOR_EACH_ALGO),
            ],
            $results
        );
    }

    private function getAverageTimeForAlgorithm(callable $fn): float
    {
        $startTime = microtime(true);
        call_user_func($fn);

        return microtime(true) - $startTime;
    }

    private function setHaystack(int $counter): void
    {
        echo 'Measurements left: ' . (self::MEASUREMENTS_FOR_EACH_ALGO - $counter) . PHP_EOL;
        echo 'Generating new random array...' . PHP_EOL;
        $this->haystack = (new RandomArray(1, self::MAX_INT))->getData();
        echo 'Measuring...' . PHP_EOL;
    }
}
