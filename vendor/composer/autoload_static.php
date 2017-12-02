<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf481148572394624c8d71cd8337cf14e
{
    public static $prefixLengthsPsr4 = array (
        'N' => 
        array (
            'NickSynev\\MakeObserverCommand\\' => 30,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'NickSynev\\MakeObserverCommand\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf481148572394624c8d71cd8337cf14e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf481148572394624c8d71cd8337cf14e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
