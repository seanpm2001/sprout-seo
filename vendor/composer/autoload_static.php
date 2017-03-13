<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit03bbce6999103e66a1fba5097ede868b
{
    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'CommerceGuys\\Intl\\' => 18,
            'CommerceGuys\\Enum\\' => 18,
            'CommerceGuys\\Addressing\\' => 24,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'CommerceGuys\\Intl\\' => 
        array (
            0 => __DIR__ . '/..' . '/commerceguys/intl/src',
        ),
        'CommerceGuys\\Enum\\' => 
        array (
            0 => __DIR__ . '/..' . '/commerceguys/enum/src',
        ),
        'CommerceGuys\\Addressing\\' => 
        array (
            0 => __DIR__ . '/..' . '/commerceguys/addressing/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'L' => 
        array (
            'LanguageDetector' => 
            array (
                0 => __DIR__ . '/..' . '/crodas/languagedetector/lib',
            ),
        ),
        'D' => 
        array (
            'Doctrine\\Common\\Collections\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/collections/lib',
            ),
        ),
    );

    public static $classMap = array (
        'crodas\\TextRank\\Config' => __DIR__ . '/..' . '/crodas/text-rank/lib/TextRank/Config.php',
        'crodas\\TextRank\\DefaultEvents' => __DIR__ . '/..' . '/crodas/text-rank/lib/TextRank/DefaultEvents.php',
        'crodas\\TextRank\\POS\\English\\Tagger' => __DIR__ . '/..' . '/crodas/text-rank/lib/TextRank/POS/English/Tagger.php',
        'crodas\\TextRank\\Stopword' => __DIR__ . '/..' . '/crodas/text-rank/lib/TextRank/Stopword.php',
        'crodas\\TextRank\\Summary' => __DIR__ . '/..' . '/crodas/text-rank/lib/TextRank/Summary.php',
        'crodas\\TextRank\\SummaryPageRank' => __DIR__ . '/..' . '/crodas/text-rank/lib/TextRank/SummaryPageRank.php',
        'crodas\\TextRank\\TextRank' => __DIR__ . '/..' . '/crodas/text-rank/lib/TextRank/TextRank.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit03bbce6999103e66a1fba5097ede868b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit03bbce6999103e66a1fba5097ede868b::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit03bbce6999103e66a1fba5097ede868b::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit03bbce6999103e66a1fba5097ede868b::$classMap;

        }, null, ClassLoader::class);
    }
}
