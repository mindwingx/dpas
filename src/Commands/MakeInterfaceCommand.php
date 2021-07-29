<?php

namespace mindwingx\dpas\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Mindwingx\Dpas\Commands\Helper\DpasParams;
use Mindwingx\Dpas\Commands\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;

class MakeInterfaceCommand extends GeneratorCommand
{
    use Helper, CreatesMatchingTest;

    /**
     * @var string
     */
    protected $signature = 'dpas:interface
    {name : Interface name}
    {--path=Services : Interface main directory path}
    {--s|stub= : Design Pattern stub name}
    {--r|rename= : Make default name available}';
    /**
     * @var string
     */
    protected $description = 'Create new interface for pattern';
    /**
     * @var string
     */
    protected $type = 'Interface';
    /**
     * @var bool
     */
    protected $hidden = true;
    /**
     * @var
     */
    protected $serviceName;

    /**
     * @return false|void
     * @throws FileNotFoundException
     * this method overwrites GeneratorCommand to avoid some messages
     */
    public function handle()
    {
        return $this->handleOverride();
    }


    /**
     * @param $stub
     * @param $name
     * @return array|string
     */
    protected function replaceClass($stub, $name): array|string
    {
        $stub = parent::replaceClass($stub, $name);
        //Dummy names handling
        $contract = preg_replace("/(.*)\//", '', $this->argument('name')) . DpasParams::INTERFACE;

        return str_replace('DummyContract', $this->renameOptionChecker($contract), $stub);
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        return __DIR__ . "/../../resources/stubs/{$this->option('stub')}.stub";
    }

    /**
     * @param $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\\' . $this->option('path');
    }

    /**
     * @return array[]
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the contract.'],
        ];
    }

    /**
     * @param $name
     * @return string
     */
    protected function getNamespace($name): string
    {
        //check to refactor nameSpace or not
        $nameSpace = substr_count($name, '\\') > 2
            ? preg_replace('/\/[^\/]+$/', '', $this->convertSlash($name))
            : $name;

        return $this->convertSlash($nameSpace, true);
    }

    /**
     * @param $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $rename = $this->convertSlash($name);
        //complete new service path
        $rename .= '/' . preg_replace('/(.*)\//', '', $rename);
        //update name if there is subdirectory
        strpos($this->argument('name'), '/') &&
        $rename = preg_replace('/\/[^\/]+$/', '', $rename);

        return $this->laravel['path'] . '/' . $this->renameOptionChecker($rename) . DpasParams::INTERFACE . DpasParams::FILE_FORMAT;
    }
}
