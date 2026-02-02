<?php
namespace Config;

use Closure;

class Container
{
    protected $bindings = [];
    protected $singletones = [];

    public function bind(string $key, Closure $closure)
    {
        $this->bindings[$key] = $closure;
    }
    public function singleton(string $key, Closure $closure)
    {
        $this->singletones[$key] = $closure();
    }

    public function make(string $key)
    {
        if (isset($this->singletones[$key])) {
            return $this->singletones[$key];
        }

        return $this->bindings[$key];
    }
}
