<?php

namespace App\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

final class Container implements ContainerInterface
{
    private $aliases = [];
    private $factories = [];

    public function __construct(array $config)
    {
        foreach ($config as $key => $value) {
            if (is_callable($value)) {
                $this->factories[$key] = $value;
                continue;
            }
            $this->aliases[$key] = $value;
        }

        foreach ($this->aliases as $alias => $resolve) {
            if (!isset($this->factories[$resolve])) {
                throw new \Exception();
            }
        }
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new \Exception();
        }

        if ($this->factories[$id]) {
            return call_user_func($this->factories[$id], $this);
        }

        if ($this->aliases[$id]) {
            return call_user_func($this->factories[$this->aliases[$id]], $this);
        }

        throw new \Exception();
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function has($id)
    {
        return (isset($this->aliases[$id]) && isset($this->factories[$this->aliases[$id]]))
            || isset($this->factories[$id]);
    }


}