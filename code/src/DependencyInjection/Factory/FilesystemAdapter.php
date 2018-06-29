<?php
/**
 * Created by PhpStorm.
 * User: axel
 * Date: 28/06/18
 * Time: 09:55
 */

namespace App\DependencyInjection\Factory;

use App\DependencyInjection\Exception\InvalidConfigurationException;
use Gaufrette\Adapter\Local;
use Psr\Container\ContainerInterface;

final class FilesystemAdapter
{
    public function __invoke(ContainerInterface $container)
    {
        return new Local(
            $container->get('file_path'),
            true,
            0750
        );
    }
}