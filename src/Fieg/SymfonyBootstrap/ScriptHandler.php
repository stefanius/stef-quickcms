<?php

namespace Fieg\SymfonyBootstrap;

//use Composer\Script\Event;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ScriptHandler
{
    public static function patch($event)
    {
//        $composer = $event->getComposer();

        $rootDir = __DIR__ . '/../../..';

        $filesystem = new Filesystem();
        $finder = new Finder();
        $finder
            ->in($rootDir . '/vendor/symfony/framework-standard-edition')
            ->depth(0)
            ->notName('composer.json')
            ->ignoreDotFiles(false)
        ;

        /** @var $file SplFileInfo */
        foreach($finder as $file) {
            $targetPath = $rootDir . '/' . $file->getFilename();

            printf("Coping %s\n", 'vendor/symfony/framework-standard-edition/' . $file->getRelativePathname());

            if ($file->isDir()) {
                $filesystem->mirror($file, $targetPath);
            } else {
                $filesystem->copy($file, $targetPath);
            }
        }
    }
}
