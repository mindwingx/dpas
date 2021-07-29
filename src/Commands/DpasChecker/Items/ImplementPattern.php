<?php

namespace Mindwingx\Dpas\Commands\DpasChecker\Items;

use Mindwingx\Dpas\Commands\DpasChecker\ServiceChecker;

class ImplementPattern extends ServiceChecker
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
        $pattern = config("dpas.implement.{$byPass['pattern']}");
        //check count of interfaces that have to be implemented
        $checkInterface = in_array('i', $pattern['steps']) &&
            array_count_values($pattern['steps'])['i'] === 1;

        foreach ($pattern['steps'] as $step => $imp) {
            //each pattern has implementation config steps which are accessible by array key.
            //check for interface command
            ($imp === 'i') && $this->command->call('dpas:interface', [
                'name' => $byPass['serviceName'] . $pattern['details'][$step],
                '--path' => $byPass['path'],
                '--stub' => $this->defaultSubChecker('interface', $pattern, $step),
                '--rename' => $pattern['rename'][$step],
            ]);

            //check for class or abstract class command
            ($imp === 'c' || $imp === 'a') && $this->command->call('dpas:class', [
                'name' => $byPass['serviceName'] . $pattern['details'][$step],
                '--path' => $byPass['path'],
                '--stub' => $this->defaultSubChecker('class', $pattern, $step),
                '--rename' => $pattern['rename'][$step],
                '--interface' => $checkInterface,
            ]);
        }

        $this->command->info(__("mindwingx::dpas.msg.service.done"));
    }
}
