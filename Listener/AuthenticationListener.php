<?php
// Mesd/UserBundle/Listener/AuthenticationListener
 
namespace Mesd\UserBundle\Listener;
 
use Symfony\Component\Security\Core\AuthenticationEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Event\AuthenticationFailureEvent;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;

use Mesd\UserBundle\Model\UserManager;
use Mesd\Orcase\UserBundle\Entity\User;

use Doctrine\ORM\EntityManager;
 
class AuthenticationListener implements EventSubscriberInterface
{

    protected $em;

    public function __construct(Doctrine $doctrine)
    {
        $this->em = $doctrine->getEntityManager();
    }

    /*
    protected $userManager;

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }
    */

    /**
     * getSubscribedEvents
     *
     * @author  Joe Sexton <joe@webtipblog.com>
     * @return  array
     */
    public static function getSubscribedEvents()
    {
        return array(
            AuthenticationEvents::AUTHENTICATION_FAILURE => 'onAuthenticationFailure',
            AuthenticationEvents::AUTHENTICATION_SUCCESS => 'onSecurityInteractiveLogin',
        );
    }
 
    /**
     * onAuthenticationFailure
     *
     * @author  Joe Sexton <joe@webtipblog.com>
     * @param   AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailure(AuthenticationFailureEvent $event)
    {
        // executes on failed login
    }
 
    /**
     * onAuthenticationSuccess
     *
     * @author  Joe Sexton <joe@webtipblog.com>
     * @param   InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof User) {
            $user->setLastLogin(new \DateTime());
            $this->em->flush();
        }
    }
}