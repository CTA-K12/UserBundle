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

        // Store mesd_user config parameters in container
        foreach( $config as $parameter => $value ) {

            $container->setParameter(
                'mesd_user.' . $parameter,
                $value
            );
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        // Check if group configuration is set, load group service if yes
        if ($container->hasParameter('mesd_user.group_class')) {
            $loader->load('GroupManagerService.yml');
            $container->setParameter('mesd_user.group_class_placeholder', $container->getParameter('mesd_user.group_class'));
        }
        else {
            $container->setParameter('mesd_user.group_class_placeholder', null);
        }

        // Load user and role services
        $loader->load('UserManagerService.yml');
        $loader->load('RoleManagerService.yml');

    }
}