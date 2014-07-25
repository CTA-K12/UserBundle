<?php

namespace Mesd\UserBundle\Model;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
// use Symfony\Component\Security\Core\User\UserInterface as SecurityUserInterface;
// use Symfony\Component\Security\Core\User\UserProviderInterface;
// use Mesd\UserBundle\Model\GroupInterface;
// use Mesd\UserBundle\Model\RoleInterface;
// use Mesd\UserBundle\Model\UserInterface;


class UserManager {

    private $objectManager;
    private $encoderFactory;
    private $userClass;
    private $roleClass;

    public function __construct($objectManager, EncoderFactoryInterface $encoderFactory, $userClass, $roleClass)
    {
         $this->objectManager  = $objectManager->getEntityManager();
         $this->encoderFactory = $encoderFactory;
         $this->userClass      = $userClass;
         $this->roleClass      = $roleClass;
    }


    public function createUser($username, $email, $password)
    {
        $user = new $this->userClass();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setPlainPassword($password);
        $encoder = $this->encoderFactory->getEncoder($user);
        $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        $user->eraseCredentials();
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }

    public function getUsers()
    {
        return $this->objectManager
                ->getRepository($this->userClass)
                ->findBy(
                    array(),
                    array('username' => 'ASC')
                    );
    }

    public function promoteUser($username, $role)
    {
        // $user = new $this->userClass();
        // $user->setUsername($name);
        // $user->setEmail($email);
        // $user->setPlainPassword($password);
        // $encoder = $this->encoderFactory->getEncoder($user);
        // $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
        // $user->eraseCredentials();
        // $this->objectManager->persist($user);
        // $this->objectManager->flush();
    }

}