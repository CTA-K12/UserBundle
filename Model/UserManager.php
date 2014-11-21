<?php

namespace Mesd\UserBundle\Model;

use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Doctrine\ORM\NoResultException;
use Mesd\UserBundle\Model\UserInterface;


class UserManager {

    private $objectManager;
    private $encoderFactory;
    private $groupClass;
    private $roleClass;
    private $userClass;

    public function __construct($objectManager, EncoderFactoryInterface $encoderFactory, $userClass, $roleClass, $groupClass = null)
    {
         $this->objectManager  = $objectManager->getManager();
         $this->encoderFactory = $encoderFactory;
         $this->userClass      = $userClass;
         $this->roleClass      = $roleClass;
         $this->groupClass     = $groupClass;
    }


    public function createUser()
    {
        $user = new $this->userClass();

        return $user;
    }


    public function demoteUser($username, $roleName)
    {
        $user = $this->objectManager
            ->getRepository($this->userClass)
            ->findOneByUsername($username);

        if(!$user) {
            throw new \Exception (sprintf("User %s not found.", $username));
        }

        $role = $this->objectManager
            ->getRepository($this->roleClass)
            ->findOneByName($roleName);

        if(!$role) {
            throw new \Exception (sprintf("Role %s not found.", $roleName));
        }

        $user->removeRole($role);
        $this->objectManager->flush();
    }


    public function disjoinUser($username, $groupName)
    {
        if (null === $this->groupClass) {
            throw new \Exception (sprintf("Group Entity Class not defined."));
        }


        $user = $this->objectManager
            ->getRepository($this->userClass)
            ->findOneByUsername($username);

        if(!$user) {
            throw new \Exception (sprintf("User %s not found.", $username));
        }

        $group = $this->objectManager
            ->getRepository($this->groupClass)
            ->findOneByName($groupName);

        if(!$group) {
            throw new \Exception (sprintf("Group %s not found.", $groupName));
        }

        $user->removeGroup($group);

        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }


    public function findUserByConfirmationToken($token)
    {
        return $this->objectManager
                ->getRepository($this->userClass)
                ->findOneByConfirmationToken(
                    array($token)
                );
    }


    public function findOneByUsernameOrEmail($credential)
    {
        $credential = mb_convert_case(
            $credential,
            MB_CASE_LOWER,
            mb_detect_encoding($credential)
        );

        $q = $this->objectManager
                ->getRepository($this->userClass)
                ->createQueryBuilder('u');

        $q->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $credential)
            ->setParameter('email', $credential)
        ;

        $result = $q->getQuery();

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $result->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }

        return $user;
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


    public function hasGroup($username, $groupName)
    {
        if (null === $this->groupClass) {
            throw new \Exception (sprintf("Group Entity Class not defined."));
        }

        $user = $this->objectManager
            ->getRepository($this->userClass)
            ->findOneByUsername($username);

        if(!$user) {
            throw new \Exception (sprintf("User %s not found.", $username));
        }

        $group = $this->objectManager
            ->getRepository($this->groupClass)
            ->findOneByName($groupName);

        if(!$group) {
            throw new \Exception (sprintf("Group %s not found.", $groupName));
        }

        return in_array($groupName,$user->getGroupNames());
    }


    public function hasRoleFromGroups($username, $roleName)
    {
        if (null === $this->groupClass) {
            throw new \Exception (sprintf("Group Entity Class not defined."));
        }

        $user = $this->objectManager
            ->getRepository($this->userClass)
            ->findOneByUsername($username);

        if(!$user) {
            throw new \Exception (sprintf("User %s not found.", $username));
        }

        $role = $this->objectManager
            ->getRepository($this->roleClass)
            ->findOneByName($roleName);

        if(!$role) {
            throw new \Exception (sprintf("Role %s not found.", $roleName));
        }

        return in_array($roleName,$user->getRoleNamesFromGroups());
    }


    public function hasRoleStandalone($username, $roleName)
    {
        $user = $this->objectManager
            ->getRepository($this->userClass)
            ->findOneByUsername($username);

        if(!$user) {
            throw new \Exception (sprintf("User %s not found.", $username));
        }

        $role = $this->objectManager
            ->getRepository($this->roleClass)
            ->findOneByName($roleName);

        if(!$role) {
            throw new \Exception (sprintf("Role %s not found.", $roleName));
        }

        return in_array($roleName,$user->getRoleNamesStandalone());
    }


    public function joinUser($username, $groupName)
    {
        if (null === $this->groupClass) {
            throw new \Exception (sprintf("Group Entity Class not defined."));
        }

        $user = $this->objectManager
            ->getRepository($this->userClass)
            ->findOneByUsername($username);

        if(!$user) {
            throw new \Exception (sprintf("User %s not found.", $username));
        }

        $group = $this->objectManager
            ->getRepository($this->groupClass)
            ->findOneByName($groupName);

        if(!$group) {
            throw new \Exception (sprintf("Group %s not found.", $groupName));
        }

        $user->addGroup($group);

        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }


    public function promoteUser($username, $roleName)
    {
        $user = $this->objectManager
            ->getRepository($this->userClass)
            ->findOneByUsername($username);

        if(!$user) {
            throw new \Exception (sprintf("User %s not found.", $username));
        }

        $role = $this->objectManager
            ->getRepository($this->roleClass)
            ->findOneByName($roleName);

        if(!$role) {
            throw new \Exception (sprintf("Role %s not found.", $roleName));
        }

        $user->addRole($role);

        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }


    public function updatePassword(UserInterface $user)
    {
        if (0 !== strlen($password = $user->getPlainPassword())) {
            $encoder = $this->encoderFactory->getEncoder($user);
            $user->setPassword($encoder->encodePassword($password, $user->getSalt()));
            $user->eraseCredentials();
        }
    }


    public function updateUser(UserInterface $user)
    {
        $this->updatePassword($user);
        $this->objectManager->persist($user);
        $this->objectManager->flush();
    }

}