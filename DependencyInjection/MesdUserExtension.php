<?php

namespace Mesd\UserBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class MesdUserExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);


        // Store mesd_user config parameters in container
        foreach( $config as $parameter => $value ) {

            if (is_array($value)) {
                foreach ($value as $key => $val) {
                    if (is_array($val)) {
                        foreach ($val as $k => $v) {
                            $container->setParameter(
                                'mesd_user.' . $parameter . '.' . $key . '.' . $k,
                                $v
                            );
                        }
                    }
                    else {
                        $container->setParameter(
                            'mesd_user.' . $parameter . '.' . $key,
                            $val
                        );
                    }
                }
            }
            else {
                $container->setParameter(
                    'mesd_user.' . $parameter,
                    $value
                );
            }
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        //Load the listeners
        $loader->load('Listeners.yml');

        //Grab the definition to the user load metadata listener
        $userMetadataListener = $container->getDefinition('mesd_user.listeners.user_load_metadata');

        // Check if group configuration is set, load group service if yes
        if ($container->hasParameter('mesd_user.group_class')) {
            $loader->load('GroupManagerService.yml');
            $container->setParameter('mesd_user.group_class_placeholder', $container->getParameter('mesd_user.group_class'));

            //Set the groups enabled on the user metadata listener to true
            $userMetadataListener->addMethodCall('setGroupsEnabled', array(true));
        }
        else {
            $container->setParameter('mesd_user.group_class_placeholder', null);

            //Set the groups enabled on the user metadata listener to false
            $userMetadataListener->addMethodCall('setGroupsEnabled', array(false));
        }

        // Check if filter configuration is set, load filter service if yes
        if ($container->hasParameter('mesd_user.filter_class')) {

            $loader->load('FilterManagerService.yml');
            $container->setParameter('mesd_user.filter_class_placeholder', $container->getParameter('mesd_user.filter_class'));

            //Set the filters enabled on the user metadata listener to true
            $userMetadataListener->addMethodCall('setFiltersEnabled', array(true));

            // Once the services definition are read, get your service and add a method call to setConfig()
            $sillyServiceDefinition = $container->getDefinition( 'mesd_user.filter_manager' );

            $sillyServiceDefinition->addMethodCall( 'setBypassRoles', array( $config[ 'filter' ][ 'bypass_roles' ] ) );
        }
        else {
            $container->setParameter('mesd_user.filter_class_placeholder', null);

            //Set the filters enabled on the user metadata listener to false
            $userMetadataListener->addMethodCall('setFiltersEnabled', array(false));
        }

        // Load default services
        $loader->load('UserManagerService.yml');
        $loader->load('RoleManagerService.yml');
        $loader->load('UserProviderService.yml');
        $loader->load('TwigExtensions.yml');


    }
}