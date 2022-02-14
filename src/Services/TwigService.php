<?php
declare(strict_types=1);

namespace Webinity\Framework\Services;

use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Webinity\Framework\TwigExtensions\AssetExtension;

class TwigService extends Service
{

    public function register()
    {
        $this->container->set('view', function() {
            return Twig::create($this->getTemplatesDir(), ['cache' => $this->getCacheDir()]);
        });
        // Add extensions to register custom functions
        $this->container->get('view')->addExtension(new AssetExtension($this->config));
    }

    public function load()
    {

    }

    public function middleware()
    {
        $this->app->add(TwigMiddleware::createFromContainer($this->app));
    }


    /**
     * Returns PATH to cache if cache is enabled in config
     * @return false|string
     */
    private function getCacheDir()
    {
        $cacheEnabled = $this->config->get('twig','cache');
        return $cacheEnabled ? $this->config->get('twig','cacheDir') : false;
    }

    /**
     * Returns PATH to templates from config
     * @return mixed
     */
    private function getTemplatesDir()
    {
        return $this->config->get('twig', 'templatesDir');
    }
}