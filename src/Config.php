<?php declare(strict_types=1);

namespace Webinity\Framework;

use Psr\Container\ContainerInterface;
use Webinity\Framework\Interfaces\ConfigInterface;

class Config implements ConfigInterface
{
    /**
     * Config directory
     * @var array
     */
    private $config;


    /**
     * Config constructor.
     */
    public function __construct(string $config)
    {
        $this->config = $config;
    }

    /**
     * If no key, return config array
     * If key, return it, else return false if key doesn't exist
     * @param string $file What config file to query
     * @param string $key
     * @return mixed
     * @throws \Exception
     */
    public function get(string $file, string $key = '')
    {
        $configPath = $this->config . "/$file.php";
        if (file_exists($configPath))
        {
            $configFile = require($configPath);
            if (empty($key)) return $configFile;

            return (isset($configFile[$key])) ? $configFile[$key] : false;
        }else{
            throw new \Exception("Config File named `$file` was not found");
        }

    }
}