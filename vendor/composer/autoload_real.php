<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitb4e812e4ca6df44a7b389da5dc8ed430
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitb4e812e4ca6df44a7b389da5dc8ed430', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitb4e812e4ca6df44a7b389da5dc8ed430', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitb4e812e4ca6df44a7b389da5dc8ed430::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
