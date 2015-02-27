<?php

namespace Padam87\AttributeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

class Padam87AttributeExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
	$loader = new YamlFileLoader(
	    $container,
	    new FileLocator(__DIR__ . '/../Resources/config')
	);
	$loader->load('services.yml');
    }
}
