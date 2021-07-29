<?php

namespace mindwingx\dpas\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeInterfaceCommand extends GeneratorCommand
{
    const INTFC = 'Interface';
    const FILE_FORMAT = '.php';

    protected $signature = 'dpas:interface 
    {name : Interface name} 
    {--path=Services : Interface main directory path}
    {--s|stub= : Design Pattern stub name}
    {--r|rename= : Make default name available}';
    protected $description = 'Create new interface for pattern';
    protected $type = 'Interface';
    protected $hidden = true;
    protected $serviceName;

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);
        //Dummy names handling
        $contract = preg_replace("/(.*)\//", '', $this->argument('name')) . self::INTFC;

        return str_replace('DummyContract', $this->renameOptionChecker($contract), $stub);
    }

    protected function getStub()
    {
        return __DIR__ . "/../../resources/stubs/{$this->option('stub')}.stub";
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\' . $this->option('path');
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the contract.'],
        ];
    }

    protected function getNamespace($name)
    {
        //check to refactor nameSpace or not
        $nameSpace = substr_count($name, '\\') > 2
            ? preg_replace('/\/[^\/]+$/', '', $this->convertSlash($name))
            : $name;

        return $this->convertSlash($nameSpace, true);
    }

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $rename = $this->convertSlash($name);
        //complete new service path
        $rename .= '/' . preg_replace('/(.*)\//', '', $rename);
        //update name if there is subdirectory
        strpos($this->argument('name'), '/') &&
            $rename = preg_replace('/\/[^\/]+$/', '', $rename);

        return $this->laravel['path'] . '/' . $this->renameOptionChecker($rename) . self::INTFC . self::FILE_FORMAT;
    }

    //helper methods
    private function convertSlash($name, $reverse = false)
    {
        $search = $reverse ? '/' : '\\';
        $replace = $reverse ? '\\' : '/';

        return str_replace($search, $replace, $name);
    }

    private function setServiceName()
    {
        $this->serviceName = preg_replace('/\/(.*)/', '', $this->argument('name'));
    }

    private function renameOptionChecker($rename)
    {
        $this->setServiceName();

        return $this->option('rename')
            ? preg_replace('/(ServiceName)/', $this->serviceName, $rename)
            : $rename;
    }

}
