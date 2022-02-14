<?php declare(strict_types=1);

namespace Webinity\Framework;

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Webinity\Framework\Config;
use Webinity\Framework\Interfaces\ConfigInterface;
use Webinity\Framework\Boostrapper;

class Bootstrapper{

    protected $config;
    protected $cache;
    protected $dotenv;

    public function __construct(string $dotenv, string $config, string $cache)
    {
        $this->config = $config;
        $this->cache = $cache;
        $this->dotenv = $dotenv;
    }

    public function app()
    {
        // Load .env file
        $dotenv = \Dotenv\Dotenv::createImmutable($this->dotenv);
        $dotenv->safeLoad();

        // Instantiate PHP-DI ContainerBuilder
        $containerBuilder = new ContainerBuilder();

        /**
         * Compile the container
         * When you deploy new versions of your code to production you must delete the generated file
         * (or the directory that contains it) to ensure that the container is re-compiled.
         * @see https://php-di.org/doc/performances.html#setup
         */
        if ($_ENV['ENVIRONMENT'] == "PRODUCTION") {
            $containerBuilder->enableCompilation();
        }

        // Add Definitions
        // Config
        $containerBuilder->addDefinitions([
            ConfigInterface::class => function () {
                return new Config($this->config);
            },
        ]);

        /*
        * Build the container
        */
        $container = $containerBuilder->build();

        /**
         * Create \Slim\App
         */
        AppFactory::setContainer($container);
        $app = AppFactory::create();
        $container->set('app', $app);

        // Register services
        $config = $container->get(ConfigInterface::class);
        $services = $config->get('app','services');

        // Register
        foreach ($services as $service) {
            $ser = $container->get($service);
            $ser->register();
        }
        // Middleware
        foreach ($services as $service) {
            $ser = $container->get($service);
            $ser->middleware();
        }
        // Load
        foreach ($services as $service) {
            $ser = $container->get($service);
            $ser->load();
        }

        return $app;
    }
}