<?php

namespace Mesd\UserBundle\Twig;

use Twig_Extension;
use Symfony\Component\DependencyInjection\ContainerInterface;

class MesdUserConfigExtension extends Twig_Extension
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getGlobals()
    {
        // print "<pre>";
        // print_r($this->container->getParameterBag()->all());exit;
        // Make MesdUserBundle config parameters into twig globals
        $keys = preg_grep(
                    '/^mesd_user/',
                    array_keys($this->container->getParameterBag()->all())
                );

        foreach ( $keys as $k => $v ) {
            $params[str_replace('.', '_', $v)] = $this->container->getParameter($v);
        }

        return $params;
    }

    public function getName()
    {
        return 'mesd_user_config_extension';
    }

}