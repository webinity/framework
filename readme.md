# webinity-skeleton

Webinity-skeleton is fantastic starting point for quick websites or prototypes.

Powered by [Slim Framework](http://www.slimframework.com/), [Twig](https://twig.symfony.com/) and CSS framework of your chosing! :)

## Requirements

- php >= 7.4

# Install
WIP
`docker-compose up -d`

## Services
This skeleton is running on services. You can define services you need by editing
`config/app.php`'s services key.

## Routes

Routes are located in `/routes/` folder. You can define your own files in `config/app.php`.


To access `Slim\Views\Twig` instance, you can do it either by
* Accessing container `$this->get('view')->render...`
* Using use clause while making a route. 
```
    // Using use clause to inherit Slim\Views\Twig instance as $view variable
    $app->get('/', function (Request $request, Response $response) use ($view) {
        return $view->render($response, 'index.twig', ['text' => 'Hello World!']);
    });
```
See `/routes/web.php` route as an example.

_For more information about how to use Routes, [check](https://www.slimframework.com/docs/v4/objects/routing.html)_ 

## Controllers
To use routes with controller methods, first create a controller in `app/Controllers` which extends
`\Webinity\Skeleton\Controller`.

Then call the controller methods like so:
```
$app->get('/controller', \Webinity\App\Controllers\HomeController::class . ':index');
```

You can access container from Controller via `$this->container` and Twig is already prepared for use as 
`$this->view`.

Simple Controller method returning Twig view would look like so:
```
    public function index(Request $request, Response $response) : ResponseInterface
    {
        return $this->view->render($response, 'index.twig', ['text' => 'Hello World from Controller']);
    }
```

## Templating - TwigService
This Skeleton is using [Twig template engine](https://twig.symfony.com/).
### Access instance
How to access Twig instance in inline routes or controllers, reference [Routes](#routes) 
or [Controllers](#controllers) documentation. It is explained in there.

#### Caching
By default, twig caching is disabled. You can enable caching and set cache directory in `/config/twig.php`,
respectively `cache` and `cacheDir` values.

#### Templates
Templates directory is located in `/resources/templates`. You can change this in `/config/twig.php` by
editing `templatesDir` value.



_For more information how to use Twig in Slim 
[check twig-view documentation](https://github.com/slimphp/Twig-View) or
[Twig documentation](https://twig.symfony.com/doc/3.x/)._ 

## Database - DibiService
Dibi connection instance is stored in container as `dibi`. You can access it just as anything else from container.
For example:
```
  // inline route
  $result = $this->get('dibi')->query('SELECT * FROM `test`')->fetchAll();
```

For more information about dibi, check [documentation](https://dibiphp.com/cs/documentation).


## CORS
Cors is enabled by CorsService, to disable it remove it from `config\app.php` [services].

For CORS to work properly, you HAVE to set `site_url` in `config\app.php`. 
If it is not set, CORS middleware won't be added to `$app`.

To read more about CORS in Slim Framework, read [here](https://www.slimframework.com/docs/v4/cookbook/enable-cors.html).







TODO

- composer install
- npm install
- copy `.env.example` file in root and name it `.env`

**To compile js/css:** run any script defined in `package.json` or add your own.

# How to

## Routes

Add routes to `/src/Routes/web.php` or `/src/Routes/api.php`\
_There is only one basic route pre-configured, which renders index.twig using layout.twig. For more examples, see Examples section._

## Controllers
You can use controllers in routes like this:
```
$app->get('/test', Phisolutions\Controllers\TestController::class . ':test');
```
*This will call method `test()` on `Phisolutions\Controllers\TestController`.*

- To create a controller, create a file in `src/Controllers` which uses trait `use \Phisolutions\Traits\Controller;`.

- You can access `container` in your controller like this: `$this->container(...)`.

## Templates

This skeleton is using Twig as templating engine. Views should by default go to `/resources/views/`.

- **Disable/enable template caching**: `templateCache` in config.php
  **Path to cache files**: `/cache/`

**How to render template from route**:

```
    return $this->get('view')->render($response,    'test.html', [
        'name' => $args['name']
    ]);
```

_This snippet renders `test.html` and passes \$name_

- **To echo out passed variables**: `{{name}}`

### Layouts

Twig can use layouts. Check prepared simple layout `resources/views/Templates/layouts/layout.twig` and `/resources/views/Templates/index.twig` to see how to use it and extend it.

_For further information how to use Twig in Slim [Check documentation](https://github.com/slimphp/Twig-View)_

## Container

### To access container:

**Inline Route**: `$this->get('...')`\
**Controller Routes**: `$this->container->get('config')`

### To set custom variables / instances to container

You can do this by adding code to `/src/container.php` by following same principles as already in there.

## Database

This project is using [dibi datbase wrapper](https://dibiphp.com/).
To use Database:

- Set database env variables in .env file
- Set `usingDatabase=true` in `src/config.php`
- To get database instance: `$container->get('config')`

## Emails

This is project is using [swiftmailer](https://swiftmailer.symfony.com/).
To use mailing:

- Set `usingMailer=true` in `src/config.php`
- To get mailer: `$container->get('mailer')`
- To send an email

```
    // Create a message
    $message = (new Swift_Message('Wonderful Subject'))
    ->setFrom(['john@doe.com' => 'John Doe'])
    ->setTo(['receiver@domain.org', 'other@domain.org' => 'A name'])
    ->setBody('Here is the message itself')
    ;

    //Send the message
    $result = $this->get('mailer')->send($message);
```

_For further information how to use SwiftMailer, [Check documentation](https://swiftmailer.symfony.com/docs/)_

## CORS

CORS is enabled by default.

- Set `domain = '<domain>'` in `src/config.php` to your domain in order for it to work properly.
- - If you don't set domain in config, CORS won't be enabled
- To turn CORS off, set `usingCors = false` in `src/config.php`

_For further information how to CORS works in Slim, [Check documentation](https://www.slimframework.com/docs/v4/cookbook/enable-cors.html)_

## MULTILANGUAGE
This starter also supports multilanguage powered by [Symfony's Translation Component](https://symfony.com/doc/4.2/components/translation/usage.html).

By default, there are two languages enabled: CS, EN.

- To enable multilanguage, set `multilanguage=true` in `src/config.php`. Multilanguage is enabled by default
- All language folders and files are located in `resources/lang` folder
- To add another language mutation, simply add new folder to `resources/lang` folder and create `strings.php`. For example: to add Italian language, create this file `resources/lang/it/strings.php`.
- To set default language, change `default_locale=cs` in `config.php` to anything you want. Language rendering will also fall back to this locale if strings are missing. The locale you set must have existing folder in `resources/lang`
- Multilanguage strings are automatically injected into twig templates and you can use it following [this documentation](https://symfony.com/doc/current/translation/templates.html) or simply calling this block `{% trans %}message{% endtrans %}` where message is the variable.
- Current locale is also injected into every twig template, so you can access currently selected language via variable `$app_locale`. This is good for making language selectors. You can access current locale in php code from session or container. `$_SESSION['app_locale']` or from container `$container->get('app_locale)`
- Array of available locales is also injected in twig as variable `$available_locales` or stored in container `$container->get('available_locales')`
- To change language, make `POST REQUEST` to `/locale`. Body should contain variable `locale`. You will get redirected to main page and your new locale will be set to $_SESSION.

**Check examples section for really simple language selector**

## CSS-FRAMEWORKS

### Tailwindcss

We are following [documentation](https://tailwindcss.com/docs/guides/laravel).

_At the time of writing this guide, Laravel Mix doesn't support PostCSS 8, so we we have to install the compatibility build_

- Install Tailwind and dependencies using `npm`

```
npm install -D tailwindcss@npm:@tailwindcss/postcss7-compat @tailwindcss/postcss7-compat postcss@^7 autoprefixer@^9
```

- Create config file `npx tailwindcss init`

- Configure `webpack.mix.js` file which should look something like this

```
mix.js('resources/assets/js/app.js', 'assets/js')
     .sass('resources/assets/sass/style.scss', 'assets/css')
     .postCss("resources/assets/tailwind/tailwind.css", "assets/css", [
        require("tailwindcss"),
       ]);
```

_In this example, we are using sass for our css and postCss to compile tailwind.css file. You have to create the tailwind file in `resources/assets/tailwind/tailwind.css` for this example to work_

- tailwind.css file should look like this

```
@tailwind base;
@tailwind components;
@tailwind utilities;
```

- Run any of predefined npm scripts to compile resources and your tailwind file into `assets/css`

# Examples

## Routes

**Inline route which renders twig view `index.twig`**
```
$app->get('/', function (Request $request, Response $response) {
    return $this->get('view')->render($response, 'index.twig');
    //$response->getBody()->write(json_encode($this->get('app_locale')));
    //return $response;
});
```

**Controller route which returns method `test()` on `TestController`**
```
$app->get('/test', Phisolutions\Controllers\TestController::class . ':test');
```

**API Route which returns json**
```
$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode($array));
    return $response;
});
```

## Twig Multilanguage
**Render current selected locale and list of available locales**
```
Current locale: {{ app_locale }}
List of locales: {{ available_locales | json_encode(constant('JSON_PRETTY_PRINT')) }}
```

**Simple language selector**

*You probably wanna use some js here also*
```
<form action="/locale" method="post">
  <select name="locale" id="locales">
    <option value="cs" 
    {% if app_locale == 'cs' %}
    selected="selected"
    {% endif %}
    >CZECH</option>
    <option value="en"
    {% if app_locale == 'en' %}
    selected="selected"
    {% endif %}
    >ENGLISH</option>
  </select>
  <input type="submit" value="Submit">
</form>
```
