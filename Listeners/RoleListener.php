<?php
namespace Mesd\UserBundle\Listeners;

use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Mesd\UserBundle\Entity\User;

class RoleListener {
    private $context;

    public function __construct(SecurityContext $context) {
        $this->context = $context;
    }

    public function onKernelController(FilterControllerEvent $event) {
        if($this->context->getToken() && $this->context->getToken()->getUser() instanceof User) {

            //Custom logic to see if you need to update the role or not.
            $user= $this->context->getToken()->getUser();
            $token = new UsernamePasswordToken($user, $user->getPassword(), 'main', $user->getRoles());

            $this->context->setToken($token);
        }
    }
}