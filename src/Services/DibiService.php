<?php declare(strict_types=1);

namespace Webinity\Framework\Services;

use Dibi\Connection;
use Dibi\DriverException;

class DibiService extends Service
{

    public function register()
    {
        try {
            // Create Dibi DB connection
            $database = new Connection([
                'driver'   => $_ENV['DIBI_DRIVER'],
                'host'     => $_ENV['DIBI_HOST'],
                'username' => $_ENV['DIBI_USERNAME'],
                'password' => $_ENV['DIBI_PASSWORD'],
                'database' => $_ENV['DIBI_DATABASE']
            ]);

            $this->container->set('dibi', function() use ($database){
                return $database;
            });
        }catch (DriverException $e){
            echo $e->getMessage();
            die();
        }
    }

    public function middleware()
    {

    }

    public function load()
    {

    }
}