<?php

namespace Mesd\UserBundle\Model;

use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;


class FilterManager {

    private $objectManager;
    private $filterClass;
    private $roleClass;
    private $userClass;


    public function __construct($objectManager, $userClass, $roleClass, $filterClass)
    {
         $this->objectManager = $objectManager->getManager();
         $this->userClass     = $userClass;
         $this->roleClass     = $roleClass;
         $this->filterClass    = $filterClass;
    }


    public function createFilter($name, $description = null)
    {
        $filter = new $this->filterClass();
        $filter->setName($name);
        $filter->setDescription($description);
        $this->objectManager->persist($filter);
        $this->objectManager->flush();
    }

    public function getFilters()
    {
        return $this->objectManager
                ->getRepository($this->filterClass)
                ->findBy(
                    array(),
                    array('name' => 'ASC')
                    );
    }


    public function hasRole($roleName)
    {
        $filter = $this->objectManager
            ->getRepository($this->filterClass)
            ->findOneByName($filterName);

        if(!$filter) {
            throw new \Exception (sprintf("Group %s not found.", $filterName));
        }

        $role = $this->objectManager
            ->getRepository($this->roleClass)
            ->findOneByName($roleName);

        if(!$role) {
            throw new \Exception (sprintf("Role %s not found.", $roleName));
        }

        return in_array($roleName,$filter->getRoleNames());
    }
}