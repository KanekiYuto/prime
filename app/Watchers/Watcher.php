<?php

namespace App\Watchers;

use Illuminate\Contracts\Foundation\Application;

/**
 * 监视器基抽象类
 *
 * @author beta
 */
abstract class Watcher
{

    /**
     * The configured watcher options.
     *
     * @var array
     */
    public array $options = [];

    /**
     * Create a new watcher instance.
     *
     * @param array $options
     *
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Register the watcher.
     *
     * @param Application $app
     *
     * @return void
     */
    abstract public function register(Application $app): void;

}
