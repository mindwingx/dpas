<?php


namespace mindwingx\dpas\Commands;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeServiceProviderCommand extends GeneratorCommand
{
    const FILE_FORMAT = '.php';
    const SERVICE_PROVIDER = 'ServiceProvider';

    protected $signature = 'dpas:provider
    {name : Service provider name}
    {--p|path=Services : Main path name}
    {--i|interface=Interface : Related interface name}
    {--s|stub= : Pattern stub file}';
    protected $description = 'Create new service provider for pattern';
    protected $type = 'Service Provider';
    protected $hidden = true;

    public function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        $interface = ucfirst($this->argument('name')) . $this->option('interface');

        return str_replace(
            ['DummyName', 'DummyPath', 'DummyContract'],
            [$this->argument('name'), $this->option('path'), $interface],
            $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . "/../../resources/stubs/{$this->option('stub')}.stub";
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        //convert path format
        $rename = str_replace('\\', '/', $name) . self::SERVICE_PROVIDER;
        return $this->laravel['path'] . '/Providers/Custom/' . $rename . self::FILE_FORMAT;
    }
}
