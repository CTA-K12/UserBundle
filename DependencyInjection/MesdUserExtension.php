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

        // Load default services
        $loader->load('UserManagerService.yml');
        $loader->load('RoleManagerService.yml');
        $loader->load('UserProviderService.yml');
        $loader->load('TwigExtensions.yml');


    }
}