<?php

namespace Mesd\UserBundle\Model;

class FilterManager {

    private $securityContext;
    private $objectManager;
    private $filterClass;
    private $roleClass;
    private $userClass;
    private $bypassRoles;

    public function __construct($securityContext, $objectManager, $userClass, $roleClass, $filterClass)
    {
        $this->securityContext = $securityContext;
        $this->objectManager   = $objectManager->getManager();
        $this->userClass       = $userClass;
        $this->roleClass       = $roleClass;
        $this->filterClass     = $filterClass;
    }

    public function applyFilters($queryBuilder)
    {
        $user = $this->securityContext->getToken()->getUser();
        foreach ($this->bypassRoles as $bypassRole) {
            if ($this->securityContext->isGranted($bypassRole)) {

                return $queryBuilder;
            }
        }

        $filters = $user->getFilter();

        if (0 === count($filters)) {
            $queryBuilder->andWhere('1 = 0');

            return $queryBuilder;
        }

        foreach ($filters as $filter) {
            $queryBuilder = $this->applyFilter($queryBuilder, $filter);
        }

        return $queryBuilder;
    }

    protected function applyFilter($queryBuilder, $filter)
    {
        foreach ($filter->getSolventWrappers() as $solvent) {
            $queryBuilder = $solvent->applyToQueryBuilder($queryBuilder, $solvent->getDetails());
        }


        return $queryBuilder;
    }

    public function setBypassRoles( $bypassRoles )
    {
        $this->bypassRoles = $bypassRoles;

        return $this;
    }

    public function getBypassRoles()
    {
        return $this->bypassRoles;
    }
}