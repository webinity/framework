<?php

namespace Webinity\Framework\Services;

use Webinity\Framework\View;

class RoutesService extends Service
{


    public function register()
    {

    }

    /**
     * Load routes
     */
    public function load()
    {
        foreach ($this->config->get('app', 'routes') as $routesFile)
        {
            $routes = require $routesFile;
            $routes($this->app, $this->container->get('view'));
        }
    }

    /**
     * Register Twig Middleware
     */
    public function middleware()
    {

    }
}