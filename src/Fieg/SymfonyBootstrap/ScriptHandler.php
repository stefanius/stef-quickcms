<?php

namespace Fieg\SymfonyBootstrap;

use Composer\Script\Event;

use Composer\Json\JsonManipulator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Process\Process;

class ScriptHandler
{
    protected static function getRootDir()
    {
        return __DIR__ . '/../../..';
    }

    public static function copyFramework(Event $event)
    {
        $rootDir = self::getRootDir();

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

    public static function applyPatches(Event $event)
    {
        $rootDir = self::getRootDir();

        $finder = new Finder();
        $finder->files()->in($rootDir . '/patches');

        foreach($finder as $file) {
            // printf("Patching %s (%s)\n", $file->getRelativePathname(), sprintf('patch -p0 < %s', $file->getPathname()));

            $process = new Process(sprintf('patch -p0 < %s', $file->getPathname()), self::getRootDir());
            $process->run();

            echo $process->getOutput();
        }

    }

    public static function patchComposerJson(Event $event)
    {
        $rootDir = self::getRootDir();

        $standardComposerJson = $rootDir . '/vendor/symfony/framework-standard-edition/composer.json';
        $composerJson = $rootDir . '/composer.json';

        printf("Patching composer.json\n");

        file_put_contents($composerJson, file_get_contents($standardComposerJson));

        return;
//
//        $config = json_decode(file_get_contents($standardComposerJson), true);
//        $manipulator = new JsonManipulator(file_get_contents($composerJson));
//
//        foreach($config['require'] as $package => $constraint) {
//            $manipulator->addLink('require', $package, $constraint);
//        }
//
//        foreach($config['scripts'] as $package => $constraint) {
//            $manipulator->addLink('require', $package, $constraint);
//        }
//
//        var_dump($config['scripts']); die(sprintf('Dump originated from %s on line %s', __FILE__, __LINE__));
//
//        file_put_contents($composerJson, $manipulator->getContents());
    }

    public static function runComposerUpdate(Event $event)
    {
        $composer = $event->getComposer();

        list ($cmd) = $GLOBALS['argv'];

        $process = new Process(sprintf('%s update', $cmd), self::getRootDir());
        $process->run(function ($type, $data) {
                echo $data;
            }
        );

        echo $process->getOutput();
    }
}
