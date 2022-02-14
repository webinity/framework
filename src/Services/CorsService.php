<?php

namespace Webinity\Framework\Services;

class CorsService extends Service
{

    public function register()
    {
        if (!(!$this->config->get('app', 'site_url') != 'http://mysite')){
            $this->app->options('/{routes:.+}', function ($request, $response, $args) {
                return $response;
            });
        }

    }

    public function middleware()
    {
        if (($this->config->get('app', 'site_url') != 'http://mysite')) {
            $config = $this->config;
            $this->app->add(function ($request, $handler) use ($config) {
                $response = $handler->handle($request);
                return $response
                    ->withHeader('Access-Control-Allow-Origin', $config->get('app', 'site_url'))
                    ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                    ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
            });
        }

    }

    public function load()
    {

    }
}