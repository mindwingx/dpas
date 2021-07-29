<?php

namespace Mindwingx\Dpas\Commands\DpasChecker\Items;

use Mindwingx\Dpas\Commands\DpasChecker\ServiceChecker;

class ValidateService extends ServiceChecker
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
        $serviceName = ucfirst($payload);
        $basePath = app_path($byPass['path'] . DIRECTORY_SEPARATOR . "%s" . DIRECTORY_SEPARATOR);
        $path = sprintf($basePath, $serviceName);

        if (file_exists($path)) {
            do {
                $serviceName = ucfirst($this->command->ask(__('mindwingx::dpas.err.service.exist')));
                $path = sprintf($basePath, $serviceName);
            } while (file_exists($path));
        }

        $byPass['serviceName'] = $serviceName;

        $this->nextProcess($byPass);
    }
}
