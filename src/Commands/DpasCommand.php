<?php

namespace mindwingx\dpas\Commands;

use Illuminate\Console\Command;

class DpasCommand extends Command
{
    protected $service;
    protected $model;
    protected $pattern;
    protected $path;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dpas:new
     {name : Service name}
     {--m|model= : Eloquent model name}
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
        $this->setPath();
        $this->serviceCheck();
        $this->patternSelector();
        !!$this->option('model') && $this->modelCheck();
        $this->implementPattern();
    }

    private function setPath()
    {
        $this->path = ucfirst($this->option('path'));
    }

    private function serviceCheck()
    {
        $this->service = ucfirst($this->argument('name'));
        $path = app_path("Services/{$this->service}/");
        $dirExists = file_exists($path);

        $overwrite = $dirExists && $this->confirm("This service already exist! Do you want overwrite?", false);

        $overwrite && $this->service = ucfirst($this->ask("Enter new service name"));
    }

    private function patternSelector()
    {
        $this->pattern = preg_replace(
            '/\s(.*)/',
            '',
            $this->choice("Please select your pattern", $this->getPatterns())
        );
    }

    private function modelCheck()
    {
        $this->model = $this->option('model');
        $exist = class_exists('App\\Models\\' . $this->model);

        if (!$exist) {
            $makeModel = $this->confirm("{$this->model} model does not exist. Do you want to create?", true);

            $makeModel
                ? $this->call('make:model', ['name' => $this->model])
                : $this->error('Please use an existing Eloquent Model.');
        }
    }

    private function getPatterns()
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

    private function implementPattern()
    {
        $pattern = config("dpas.implement.{$this->pattern}");
        //check count of interfaces that have to be implemented
        $checkInterface = in_array('i', $pattern['steps']) &&
            array_count_values($pattern['steps'])['i'] === 1;

        foreach ($pattern['steps'] as $step => $imp) {
            //$step : each pattern has implementation config steps which are accessible by array key.

            //check for interface command
            ($imp === 'i') && $this->call('dpas:interface', [
                'name' => $this->service . $pattern['details'][$step],
                '--path' => $this->path,
                '--stub' => $this->defaultSubChecker('interface', $pattern, $step),
                '--rename' => $pattern['rename'][$step],
            ]);

            //check for class or abstract class command
            ($imp === 'c' || $imp === 'a') && $this->call('dpas:class', [
                'name' => $this->service . $pattern['details'][$step],
                '--path' => $this->path,
                '--model' => $this->model,
                '--stub' => $this->defaultSubChecker('class', $pattern, $step),
                '--rename' => $pattern['rename'][$step],
                '--interface' => $checkInterface,
            ]);

            //check for service provider command
            if ($imp === 'p') {
                $this->call('dpas:provider', [
                    'name' => $this->service,
                    '--path' => $this->path,
                    '--stub' => $pattern['stubs'][$step],
                ]);

                $this->registerCustomProvider($this->service);
            }
        }

        //implement guide message
        $msg = "Add classes as needed into classes directory of your service.";
        $message = empty($pattern['msg']) ? $msg : $pattern['msg'];
        $this->question($message);

        isset($this->model) &&
        $this->comment("Please uncomment {$this->option('model')} model or update model path in classes.");
    }

    private function registerCustomProvider($name)
    {
        //todo: check if already exist
        $configFile = base_path() . '/config/app.php';
        $file = file_get_contents($configFile);
        $searchFor = "Package Service Providers...\n\t\t*/";
        $customProviders = strpos($file, $searchFor);

        if ($customProviders) {
            $newFile = substr_replace(
                $file,
                $searchFor . "\n\t\t" . 'App\Providers\Custom\\' . ucfirst($name) . 'ServiceProvider::class,',
                $customProviders, strlen($searchFor)
            );
            // Save file
            file_put_contents($configFile, $newFile);

            $this->comment("\nCustom service provider registered successfully.");
            $this->comment("Access to design pattern as a service via defined interface in provider. Or do more!");
        }
    }

    private function defaultSubChecker($stub, $pattern, $step)
    {
        return empty($pattern['stubs'][$step]) ? $stub : $pattern['stubs'][$step];
    }

}
