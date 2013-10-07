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
            $process = new Process(sprintf('patch -p0 < %s', $file->getPathname()), self::getRootDir(), null, null, null);
            $process->run();

            echo $process->getOutput();
        }

        // @todo do this using a patch file, but I don't how to create
        // a patch file that actually deletes a dir/file
        printf("Deleting %s\n", $rootDir . '/src/Acme');
        $filesystem = new Filesystem();
        $filesystem->remove($rootDir . '/src/Acme');
    }

    public static function patchComposerJson(Event $event)
    {
        $rootDir = self::getRootDir();

        $standardComposerJson = $rootDir . '/vendor/symfony/framework-standard-edition/composer.json';
        $composerJson = $rootDir . '/composer.json';

        printf("Patching composer.json\n");

        file_put_contents($composerJson, file_get_contents($standardComposerJson));

        return;
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

    public static function cleanup(Event $event)
    {
        $rootDir = self::getRootDir();

        $directories = array($rootDir . '/patches', $rootDir . '/src/Fieg');

        foreach($directories as $directory) {
            printf("Deleting %s\n", $directory);

            $process = new Process(sprintf('rm -rf %s', $directory), self::getRootDir(), null, null, null);
            $process->run();
        }

        printf("You need to remove %s yourself\n", $rootDir . '/src/Fieg/');
    }
}
