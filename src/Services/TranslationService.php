<?php

namespace Webinity\Framework\Services;

use Slim\Psr7\Request;
use Slim\Psr7\Response;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Component\Translation\Loader\PhpFileLoader;
use Symfony\Component\Translation\Translator;

class TranslationService extends Service
{

    public function register()
    {
        /**
         * Create a translator and set default, fallback locales
         */
        $translator = new Translator($this->config->get('app', 'default_locale'));
        $translator->addLoader('php', new PhpFileLoader());
        $translator->setFallbackLocales([$this->config->get('app', 'fallback_locale')]);

        /**
         * Sets language based on session
         * Also set it into the container
         */
        if (isset($_SESSION['app_locale'])) {
            $translator->setLocale($_SESSION['app_locale']);
            $this->container->set('app_locale', $_SESSION['app_locale']);
        } else {
            $this->container->set('app_locale', $this->config->get('app', 'default_locale'));
        }

        /**
         * Get all available languages and insert into container
         * Then loop through them and register its strings.php files to translator
         */
        $this->container->set('available_locales', function () {
            return array_values(array_diff(scandir($this->config->get('app', 'lang_path')), array('..', '.')));
        });
        foreach ($this->container->get('available_locales') as $locale) {
            $path = $this->config->get('app', 'lang_path') . "/$locale/strings.php";
            $translator->addResource('php', $path, $locale);
        }

        /**
         * Set TranslationExtension into Twig instance
         */
        $this->container->get('view')->addExtension(new TranslationExtension($translator));
        $this->container->get('view')->getEnvironment()->addGlobal('app_locale',$this->container->get('app_locale'));
        $this->container->get('view')->getEnvironment()->addGlobal('available_locales',$this->container->get('available_locales'));

        /**
         * Add route to change language
         */
        $this->app->post('/locale', function (Request $request, Response $response, $args) {
            $parsedBody = $request->getParsedBody();
            $locale = $parsedBody['locale'];

            /**
             * Check if locale is available
             */
            $available_locales = $this->get('available_locales');
            if (in_array($locale, $available_locales)){
                $_SESSION['app_locale'] = $locale;
            }

            return $response->withHeader('Location', '/');
        });

    }

    public function middleware()
    {
        // TODO: Implement middleware() method.
    }

    public function load()
    {

    }
}