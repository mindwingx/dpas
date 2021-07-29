<?php

namespace Mindwingx\Dpas\Commands\DpasChecker;

abstract class ServiceChecker
{
    use Helper;

    const SERVICE_BASE_PATH = "Services";

    /**
     * @var
     */
    protected $item;

    /**
     * @param array $byPass
     * @param null $payload
     * @return void
     */
    abstract public function handle(array $byPass, $payload = null): void;

    /**
     * @param ServiceChecker $item
     * @return void
     */
    public function processWith(ServiceChecker $item)
    {
        $this->item = $item;
    }

    /**
     * @param array $byPass
     * @param null $item
     * @return void
     */
    protected function nextProcess(array $byPass = [], $item = null)
    {
        if (isset($this->item)) {
            $this->item->handle($byPass, $item);
        }
    }
}
