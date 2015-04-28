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
                ->scalarNode('filter_class')
                ->end()
                ->arrayNode('login')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->enumNode('revisit_behavior')
                            ->values(array('logout', 'redirect', 'status'))
                            ->defaultValue('status')
                        ->end()
                        ->scalarNode('revisit_redirect_target')
                            ->defaultValue(null)
                        ->end()
                        ->scalarNode('template')
                            ->defaultValue('MesdUserBundle:Security:login.html.twig')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('registration')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('approval_mail')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('approval_mail_from')
                            ->defaultValue('webmaster@example.com')
                        ->end()
                        ->scalarNode('approval_mail_subject')
                            ->defaultValue('Account Needs Approval')
                        ->end()
                        ->scalarNode('approval_mail_to')
                            ->defaultValue(null)
                        ->end()
                        ->booleanNode('approval_required')
                            ->defaultFalse()
                        ->end()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('link_text')
                            ->defaultValue('Create Account')
                        ->end()
                        ->booleanNode('mail_confirmation')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('mail_from')
                            ->defaultValue('webmaster@example.com')
                        ->end()
                        ->scalarNode('mail_subject')
                            ->defaultValue('Account Created')
                        ->end()
                        ->arrayNode('template')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('approve')
                                    ->defaultValue('MesdUserBundle:Registration:approve.html.twig')
                                ->end()
                                ->scalarNode('approval_mail')
                                    ->defaultValue('MesdUserBundle:Registration:approvalEmail.txt.twig')
                                ->end()
                                ->scalarNode('confirm')
                                    ->defaultValue('MesdUserBundle:Registration:confirm.html.twig')
                                ->end()
                                ->scalarNode('confirm_mail')
                                    ->defaultValue('MesdUserBundle:Registration:confirmEmail.txt.twig')
                                ->end()
                                ->scalarNode('register')
                                    ->defaultValue('MesdUserBundle:Registration:register.html.twig')
                                ->end()
                                ->scalarNode('summary')
                                    ->defaultValue('MesdUserBundle:Registration:summary.html.twig')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('reset')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()
                        ->scalarNode('link_text')
                            ->defaultValue('Reset Password')
                        ->end()
                        ->scalarNode('mail_from')
                            ->defaultValue('webmaster@example.com')
                        ->end()
                        ->scalarNode('mail_subject')
                            ->defaultValue('Account Password Reset')
                        ->end()
                        ->arrayNode('template')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('already_requested')
                                    ->defaultValue('MesdUserBundle:Reset:passwordAlreadyRequested.html.twig')
                                ->end()
                                ->scalarNode('check_email')
                                    ->defaultValue('MesdUserBundle:Reset:checkEmail.html.twig')
                                ->end()
                                ->scalarNode('new_password')
                                    ->defaultValue('MesdUserBundle:Reset:newPassword.html.twig')
                                ->end()
                                ->scalarNode('request')
                                    ->defaultValue('MesdUserBundle:Reset:request.html.twig')
                                ->end()
                                ->scalarNode('reset_mail')
                                    ->defaultValue('MesdUserBundle:Reset:resetEmail.txt.twig')
                                ->end()
                                ->scalarNode('success')
                                    ->defaultValue('MesdUserBundle:Reset:success.html.twig')
                                ->end()
                            ->end()
                        ->end()
                        ->integerNode('token_ttl')
                            ->defaultValue(86400)
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
