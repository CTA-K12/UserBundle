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
                        ->booleanNode('mailConfirmation')
                            ->defaultFalse()
                        ->end()
                        ->arrayNode('template')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('confirm')
                                    ->defaultValue('MesdUserBundle:registration:confirm.html.twig')
                                ->end()
                                ->scalarNode('register')
                                    ->defaultValue('MesdUserBundle:registration:register.html.twig')
                                ->end()
                            ->end()
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
                        ->arrayNode('template')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('reset')
                                    ->defaultValue('MesdUserBundle:reset:reset.html.twig')
                                ->end()
                            ->end()
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
