<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit109e4d080799901b7296a43d14d242a5
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
        '320cde22f66dd4f5d3fd621d3e88b98f' => __DIR__ . '/..' . '/symfony/polyfill-ctype/bootstrap.php',
        '25072dd6e2470089de65ae7bf11d3109' => __DIR__ . '/..' . '/symfony/polyfill-php72/bootstrap.php',
        'f598d06aa772fa33d905e87be6398fb1' => __DIR__ . '/..' . '/symfony/polyfill-intl-idn/bootstrap.php',
        'c899bf3d7cf083b79d5e2b2575ed07d5' => __DIR__ . '/..' . '/lorenzo/pinky/src/pinky.php',
        '6a47392539ca2329373e0d33e1dba053' => __DIR__ . '/..' . '/symfony/polyfill-intl-icu/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twig\\Extra\\Markdown\\' => 20,
            'Twig\\Extra\\Intl\\' => 16,
            'Twig\\Extra\\Inky\\' => 16,
            'Twig\\Extra\\Html\\' => 16,
            'Twig\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Php72\\' => 23,
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Polyfill\\Intl\\Idn\\' => 26,
            'Symfony\\Polyfill\\Ctype\\' => 23,
            'Symfony\\Component\\Mime\\' => 23,
            'Symfony\\Component\\Intl\\' => 23,
        ),
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'L' => 
        array (
            'League\\HTMLToMarkdown\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twig\\Extra\\Markdown\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/markdown-extra/src',
        ),
        'Twig\\Extra\\Intl\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/intl-extra/src',
        ),
        'Twig\\Extra\\Inky\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/inky-extra/src',
        ),
        'Twig\\Extra\\Html\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/html-extra/src',
        ),
        'Twig\\' => 
        array (
            0 => __DIR__ . '/..' . '/twig/twig/src',
        ),
        'Symfony\\Polyfill\\Php72\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-php72',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Polyfill\\Intl\\Idn\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-intl-idn',
        ),
        'Symfony\\Polyfill\\Ctype\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-ctype',
        ),
        'Symfony\\Component\\Mime\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/mime',
        ),
        'Symfony\\Component\\Intl\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/intl',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'League\\HTMLToMarkdown\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/html-to-markdown/src',
        ),
    );

    public static $classMap = array (
        'Collator' => __DIR__ . '/..' . '/symfony/intl/Resources/stubs/Collator.php',
        'IntlDateFormatter' => __DIR__ . '/..' . '/symfony/intl/Resources/stubs/IntlDateFormatter.php',
        'Locale' => __DIR__ . '/..' . '/symfony/intl/Resources/stubs/Locale.php',
        'NumberFormatter' => __DIR__ . '/..' . '/symfony/intl/Resources/stubs/NumberFormatter.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit109e4d080799901b7296a43d14d242a5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit109e4d080799901b7296a43d14d242a5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit109e4d080799901b7296a43d14d242a5::$classMap;

        }, null, ClassLoader::class);
    }
}
