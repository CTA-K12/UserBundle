<?php

namespace Mesd\UserBundle\Model;

class RoleManager {

    private $objectManager;
    private $roleClass;

    public function __construct($objectManager, $roleClass)
    {
         $this->objectManager  = $objectManager->getEntityManager();
         $this->roleClass      = $roleClass;
    }

    public function createRole($name, $description = null)
    {
        $role = new $this->roleClass();
        $role->setName($name);
        $role->setDescription($description);
        $this->objectManager->persist($role);
        $this->objectManager->flush();
    }

    public function getRoles()
    {
        return $this->objectManager
                ->getRepository($this->roleClass)
                ->findBy(
                    array(),
                    array('name' => 'ASC')
                    );
    }

}