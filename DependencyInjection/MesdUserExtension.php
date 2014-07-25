<?php

namespace Mesd\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class MesdUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach( $config as $parameter => $value ) {

            $container->setParameter(
                'mesd_user.' . $parameter,
                $value
            );
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('UserManagerService.yml');
        $loader->load('RoleManagerService.yml');

        if ($container->hasParameter('mesd_user.group_class')) {
            $loader->load('GroupManagerService.yml');
        }

    }
}