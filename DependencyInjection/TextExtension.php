<?php
namespace Fontai\Bundle\TextBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;


class TextExtension extends Extension
{
  public function load(array $configs, ContainerBuilder $container)
  {
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
    $loader->load('text.yaml');
  }

  public function getAlias()
  {
    return 'text';
  }
}