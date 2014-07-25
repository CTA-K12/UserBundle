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


    public function getGroups()
    {
        return $this->objectManager
                ->getRepository($this->groupClass)
                ->findBy(
                    array(),
                    array('name' => 'ASC')
                    );
    }

}