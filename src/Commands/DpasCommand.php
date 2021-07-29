<?php

namespace Mindwingx\Dpas\Commands;

use Illuminate\Console\Command;
use Mindwingx\Dpas\Commands\DpasChecker\Items\ImplementPattern;
use Mindwingx\Dpas\Commands\DpasChecker\Items\SelectPattern;
use Mindwingx\Dpas\Commands\DpasChecker\Items\SetPath;
use Mindwingx\Dpas\Commands\DpasChecker\Items\ValidateService;

class DpasCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dpas:new
     {name : Service name}
     {--p|path=Services : Directory path to implement pattern}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new Service/Module according to design patterns';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $path = new SetPath($this);
        $service = new ValidateService($this);
        $pattern = new SelectPattern($this);
        $implement = new ImplementPattern($this);

        $path->processWith($service);
        $service->processWith($pattern);
        $pattern->processWith($implement);

        $path->handle();
    }
}
