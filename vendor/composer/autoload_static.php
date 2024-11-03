<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit377e4ee7c989329427f4176387fd58de
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'LifeJacket\\Client\\' => 18,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'LifeJacket\\Client\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'LifeJacket\\Client\\Plugin' => __DIR__ . '/../..' . '/includes/Plugin.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit377e4ee7c989329427f4176387fd58de::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit377e4ee7c989329427f4176387fd58de::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit377e4ee7c989329427f4176387fd58de::$classMap;

        }, null, ClassLoader::class);
    }
}
