<?php

namespace Mindwingx\Dpas\Commands\DpasChecker\Items;

use Mindwingx\Dpas\Commands\DpasChecker\ServiceChecker;

class SetPath extends ServiceChecker
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
        $byPass['path'] = is_null($this->command->option('path'))
            ? parent::SERVICE_BASE_PATH
            : ucfirst($this->command->option('path'));

        $this->nextProcess($byPass, $this->command->argument('name'));
    }
}
