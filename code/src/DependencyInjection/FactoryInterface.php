<?php

namespace App\DependencyInjection;

use Psr\Container\ContainerInterface;

interface FactoryInterface
{
    public function create(ContainerInterface $container);
}