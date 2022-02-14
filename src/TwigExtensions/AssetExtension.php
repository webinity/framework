<?php

namespace Webinity\Framework\TwigExtensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Webinity\Framework\Interfaces\ConfigInterface;

class AssetExtension extends AbstractExtension
{
    protected ConfigInterface $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function getFunctions()
    {
        return array(
            new TwigFunction('asset', array($this, 'return_asset_path')),
        );
    }

    public function return_asset_path($path)
    {
        return $this->config->get('app', 'assets_folder') . "/$path";
    }
}