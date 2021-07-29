<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd6226ad7ad06d579f573d9e6307c8438
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mindwingx\\Dpas\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mindwingx\\Dpas\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd6226ad7ad06d579f573d9e6307c8438::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd6226ad7ad06d579f573d9e6307c8438::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd6226ad7ad06d579f573d9e6307c8438::$classMap;

        }, null, ClassLoader::class);
    }
}