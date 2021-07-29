<?php

namespace Mindwingx\Dpas\Commands\DpasChecker\Items;

use Mindwingx\Dpas\Commands\DpasChecker\ServiceChecker;

class SelectPattern extends ServiceChecker
{
    /**
     * @var
     */
    private $command;

    /**
     * @param $command
     */
    public function __construct($command)
    {
        $this->command = $command;
    }

    public function handle($byPass = [], $payload = null): void
    {
        $pattern = preg_replace(
            '/\s(.*)/',
            '',
            $this->command->choice(__('mindwingx::dpas.msg.service.pattern'), $this->getPatterns())
        );

        $byPass['pattern'] = $pattern;

        $this->nextProcess($byPass);
    }
}
