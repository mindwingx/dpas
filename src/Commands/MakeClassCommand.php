<?php

namespace mindwingx\dpas\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeClassCommand extends GeneratorCommand
{
    const INTFC = 'Interface';
    const FILE_FORMAT = '.php';

    protected $signature = 'dpas:class 
    {name : Class name} 
    {--path=Services : Class main directory path} 
    {--i|interface= : Interface class name}
    {--m|model= : Eloquent Model Name}
    {--s|stub= : Design Pattern stub name}
    {--r|rename= : Make default name available}';
    protected $description = 'Create new class for pattern';
    protected $type = 'Class';
    protected $hidden = true;

    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        //$regex = $this->option('rename') ? '/\/[^\/]+$/' : '/\/(.*)/';
        //get name for path and interface
        $rename = preg_replace('/\/(.*)/', '', $this->argument('name'));
        //Dummy names handling
        //$use = $this->option('path') . '\\' . $rename . '\\interfaces\\' . $this->setInterface($rename);
        $checkName = preg_replace('/(.*)\//', '', $this->argument('name'));

        return str_replace(
            [
                'DummyUse',
                'DummyPath',
                'DummyName',
                'DummyImp',
                'DummyModel'
            ],
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
        //convert path format
        $rename = $this->convertSlash($name);
        //complete new service path
        $rename .= '/' . preg_replace('/(.*)\//', '', $rename);

        strpos($this->argument('name'), '/') &&
            $rename = preg_replace('/\/[^\/]+$/', '', $rename);

        return $this->laravel['path'] . '/' . $this->renameOptionChecker($rename) . self::FILE_FORMAT;
    }

    //custom helper methods
    private function setInterface()
    {
        $regex =  $this->option('interface') ? '/\/(.*)/' : '/(.*)\//';
        $name = preg_replace($regex, '', $this->argument('name'));

        $interface = $this->option('interface')
            ? $name
            : $this->renameOptionChecker($name);

        return $interface . self::INTFC;
    }

    private function convertSlash($name, $reverse = false)
    {
        $search = $reverse ? '/' : '\\';
        $replace = $reverse ? '\\' : '/';

        return str_replace($search, $replace, $name);
    }

    private function setServiceName()
    {
        $regex = !is_null($this->option('rename')) ? '/\/(.*)/' : '/(.*)\//';
        return preg_replace($regex, '', $this->argument('name'));
    }

    private function renameOptionChecker($rename)
    {
        //get options from config
        return $this->option('rename')
            ? str_replace('ServiceName', $this->setServiceName(), $rename)
            : $rename;
    }
}
