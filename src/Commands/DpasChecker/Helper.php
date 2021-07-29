<?php

namespace Mindwingx\Dpas\Commands\DpasChecker;

trait Helper
{
    public function getPatterns(): array
    {
        $patterns = [];

        foreach (config('dpas.patterns') as $type => $pattern) {
            $collect = [];

            foreach ($pattern as $item) {
                $collect[] = $item . " ({$type})";
            }

            $patterns = array_merge($patterns, $collect);
        }

        return $patterns;
    }

    public function defaultSubChecker($stub, $pattern, $step)
    {
        return empty($pattern['stubs'][$step]) ? $stub : $pattern['stubs'][$step];
    }
}
