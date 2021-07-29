<?php

namespace mindwingx\dpas\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Str;
use Mindwingx\Dpas\Commands\Helper\DpasParams;
use Mindwingx\Dpas\Commands\Helper\Helper;
use Symfony\Component\Console\Input\InputArgument;

class MakeClassCommand extends GeneratorCommand
{
    use Helper, CreatesMatchingTest;

    /**
     * @var string
     */
    protected $signature = 'dpas:class
    {name : Class name}
    {--path=Services : Class main directory path}
    {--i|interface= : Interface class name}
    {--m|model= : Eloquent Model Name}
    {--s|stub= : Design Pattern stub name}
    {--r|rename= : Make default name available}';
    /**
     * @var string
     */
    protected $description = 'Create new class for pattern';
    /**
     * @var string
     */
    protected $type = 'Class';
    /**
     * @var bool
     */
    protected $hidden = true;
    /**
     * @var
     */
    protected $serviceName;


    /**
     * @return bool|void
     * @throws FileNotFoundException
     */
    public function handle()
    {
        return $this->handleOverride();
    }

    /**
     * @param $stub
     * @param $name
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $stub = parent::replaceClass($stub, $name);

        //get name for path and interface
        $rename = preg_replace('/\/(.*)/', '', $this->argument('name'));
        //Dummy names handling
        $checkName = preg_replace('/(.*)\//', '', $this->argument('name'));

        return str_replace(
            DpasParams::DUMMY_ITEMS,
            [
                $rename,
                $this->option('path'),
                $this->renameOptionChecker($checkName),
                $this->setInterface(),
                $this->option('model')
            ],
            $stub
        );
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
        //convert path format
        $rename = $this->convertSlash($name);
        //complete new service path
        $rename .= '/' . preg_replace('/(.*)\//', '', $rename);

        strpos($this->argument('name'), '/') &&
        $rename = preg_replace('/\/[^\/]+$/', '', $rename);

        return $this->laravel['path'] . '/' . $this->renameOptionChecker($rename) . DpasParams::FILE_FORMAT;
    }
}
