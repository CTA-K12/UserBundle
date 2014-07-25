<?php

namespace Mesd\UserBundle\Model;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;


class GroupManager {

    private $objectManager;
    private $groupClass;
    private $roleClass;
    private $userClass;


    public function __construct($objectManager, $userClass, $roleClass, $groupClass)
    {
         $this->objectManager = $objectManager->getEntityManager();
         $this->userClass     = $userClass;
         $this->roleClass     = $roleClass;
         $this->groupClass    = $groupClass;
    }


    public function createGroup($name, $description = null)
    {
        $group = new $this->groupClass();
        $group->setName($name);
        $group->setDescription($description);
        $this->objectManager->persist($group);
        $this->objectManager->flush();
    }


    public function demoteGroup($groupName, $roleName)
    {
        $group = $this->objectManager
            ->getRepository($this->groupClass)
            ->findOneByName($groupName);

        if(!$group) {
            throw new \Exception (sprintf("Group %s not found.", $groupName));
        }

        $role = $this->objectManager
            ->getRepository($this->roleClass)
            ->findOneByName($roleName);

        if(!$role) {
            throw new \Exception (sprintf("Role %s not found.", $roleName));
        }

        $group->removeRole($role);

        $this->objectManager->persist($group);
        $this->objectManager->flush();
    }


    public function getGroups()
    {
        return $this->objectManager
                ->getRepository($this->groupClass)
                ->findBy(
                    array(),
                    array('name' => 'ASC')
                    );
    }


    public function hasRole($groupName, $roleName)
    {
        $group = $this->objectManager
            ->getRepository($this->groupClass)
            ->findOneByName($groupName);

        if(!$group) {
            throw new \Exception (sprintf("Group %s not found.", $groupName));
        }

        $role = $this->objectManager
            ->getRepository($this->roleClass)
            ->findOneByName($roleName);

        if(!$role) {
            throw new \Exception (sprintf("Role %s not found.", $roleName));
        }

        return in_array($roleName,$group->getRoleNames());
    }


    public function promoteGroup($groupName, $roleName)
    {
        $group = $this->objectManager
            ->getRepository($this->groupClass)
            ->findOneByName($groupName);

        if(!$group) {
            throw new \Exception (sprintf("Group %s not found.", $groupName));
        }

        $role = $this->objectManager
            ->getRepository($this->roleClass)
            ->findOneByName($roleName);

        if(!$role) {
            throw new \Exception (sprintf("Role %s not found.", $roleName));
        }

        $group->addRole($role);

        $this->objectManager->persist($group);
        $this->objectManager->flush();
    }

}