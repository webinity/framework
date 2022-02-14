<?php declare(strict_types=1);

namespace Webinity\Framework;

use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

class Controller
{
    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @var Twig|mixed
     */
    protected Twig $view;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->view = $container->get('view');
    }
}