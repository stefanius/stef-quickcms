<?php

namespace Fieg\SymfonyBootstrap;

//use Composer\Script\Event;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;

class ScriptHandler
{
    public static function patch($event)
    {
//        $composer = $event->getComposer();

        $filesystem = new Filesystem();
        $finder = new Finder();
        $finder
            ->in(__DIR__ . '/../../../vendor/symfony/framework-standard-edition')
            ->depth(0)
            ->notName('composer.json')
        ;

        foreach($finder as $file) {
            $filesystem->copy($file, __DIR__ . '/../../../');
        }
    }
}
