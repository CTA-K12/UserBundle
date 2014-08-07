<?php

namespace Mesd\UserBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('mesd_user')
            ->addDefaultsIfNotSet()
            ->children()
                ->scalarNode('user_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('role_class')
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('group_class')
                ->end()
                ->arrayNode('login')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('template')
                            ->defaultValue('MesdUserBundle:security:login.html.twig')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('registration')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('template')
                            ->defaultValue('MesdUserBundle:security:registration.html.twig')
                        ->end()
                        ->scalarNode('text')
                            ->defaultValue('Create Account')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('reset')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('template')
                            ->defaultValue('MesdUserBundle:security:reset.html.twig')
                        ->end()
                        ->scalarNode('text')
                            ->defaultValue('Reset Password')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
