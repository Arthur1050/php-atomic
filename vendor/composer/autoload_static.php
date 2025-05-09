<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit486b62a6612a73b697fcc2e8ddf83ddb
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Arthurspar\\Atomic\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Arthurspar\\Atomic\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit486b62a6612a73b697fcc2e8ddf83ddb::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit486b62a6612a73b697fcc2e8ddf83ddb::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit486b62a6612a73b697fcc2e8ddf83ddb::$classMap;

        }, null, ClassLoader::class);
    }
}
