<?php

namespace Mindwingx\Dpas\Commands\Helper;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

trait Helper
{
    /**
     * @return false|void
     * @throws FileNotFoundException
     */
    public function handleOverride()
    {
        if ($this->isReservedName($this->getNameInput())) {
            $this->error('The name "' . $this->getNameInput() . '" is reserved by PHP.');

            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        if ((!$this->hasOption('force') ||
                !$this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type . ' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));


        if (in_array(CreatesMatchingTest::class, class_uses_recursive($this))) {
            $this->handleTestCreation($path);
        }
    }

    /**
     * @param string $name
     * @param bool $reverse
     * @return string
     */
    public function convertSlash(string $name, bool $reverse = false): string
    {
        $search = $reverse ? '/' : '\\';
        $replace = $reverse ? '\\' : '/';

        return str_replace($search, $replace, $name);
    }

    /**
     * @return string|null
     */
    private function setServiceName(): string|null
    {
        $regex = !is_null($this->option('rename')) ? '/\/(.*)/' : '/(.*)\//';
        return preg_replace($regex, '', $this->argument('name'));
    }

    /**
     * @param string $rename
     * @return string|null
     */
    private function renameOptionChecker(string $rename): string|null
    {
        $this->setServiceName();

        return $this->option('rename')
            ? preg_replace('/(ServiceName)/', $this->serviceName, $rename)
            : $rename;
    }

    //Class Command methods

    /**
     * @return string
     */
    private function setInterface(): string
    {
        $regex = $this->option('interface') ? '/\/(.*)/' : '/(.*)\//';
        $name = preg_replace($regex, '', $this->argument('name'));

        $interface = $this->option('interface')
            ? $name
            : $this->renameOptionChecker($name);

        return $interface . DpasParams::INTERFACE;
    }
}
