<?php
declare(strict_types=1);

namespace Webinity\Framework\Services;

use Psr\Container\ContainerInterface;
use Slim\App;
use Webinity\Framework\Interfaces\ConfigInterface;

abstract class Service
{
    protected ContainerInterface $container;
    protected ConfigInterface $config;
    protected App $app;


    public function __construct(ContainerInterface $container, ConfigInterface $config)
    {
        $this->container = $container;
        $this->app = $this->container->get('app');
        $this->config = $config;
    }

    // Register this service into container
    public abstract function register();

    // Define middleware this service adds to app
    public abstract function middleware();

    // Load something on app instance if necessary
    public abstract function load();

}