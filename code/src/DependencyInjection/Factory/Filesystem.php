<?php

namespace App\DependencyInjection\Factory;

use Psr\Container\ContainerInterface;
use Gaufrette\Filesystem as GaufretteFilesystem;

final class Filesystem
{
    public function __invoke(ContainerInterface $container)
    {
        return new GaufretteFilesystem($container->get('Adapter'));
    }
}