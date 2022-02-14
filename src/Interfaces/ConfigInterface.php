<?php
declare(strict_types=1);

namespace Webinity\Framework\Interfaces;

interface ConfigInterface
{
    /**
     * @param string $file
     * @param string $key
     * @return mixed
     */
    public function get(string $file, string $key = '');
}