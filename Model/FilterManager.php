<?php

namespace Mesd\UserBundle\Model;

class FilterManager {

    private $securityContext;
    private $objectManager;
    private $filterClass;
    private $roleClass;
    private $userClass;
    private $config;

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

        foreach ($user->getFilter() as $filter) {
            $queryBuilder = $this->applyFilter($queryBuilder, $filter);
        }

        /*
        $user = $this->securityContext->getToken()->getUser();

        foreach ($this->config as $roleName => $entities) {
            var_dump('roleName', $roleName);
            foreach ($entities['entities'] as $entity) {
                foreach ($entity as $entityValue) {
                    var_dump('entityValueName', $entityValue['name']);
                    foreach ($entityValue['joins'] as $join) {
                        var_dump('join', $join);
                    }
                }
            }
        }


        var_dump($user->getRoles());

        $filters = $user->getFilter();

        foreach ($filters as $filter) {
            $solvents = $filter->getSolvent();
            foreach ($solvents as $roleName => $entities) {
                var_dump('roleName', $roleName);
                var_dump($entities);
                foreach ($entities as $entity) {
                    var_dump('entityName', $entity['name']);
                    foreach ($entity['joins'] as $joinName => $joinId) {
                        var_dump('joinName', $joinName);
                        var_dump('joinId', $joinId);
                    }
                }
            }
        }

        var_dump(__LINE__);

        foreach ($user->getFilter() as $filter) {
            foreach ($filter->getSolventWrappers() as $solvent) {
                var_dump('solventName: ' . $solvent->getName());
                foreach ($solvent->getEntity() as $entity) {
                    var_dump('entityName: ' . $entity->getName());
                    foreach ($entity->getJoin() as $join) {
                        var_dump('joinName: ' . $join->getName());
                        var_dump('joinId: ' . $join->getId());
                    }
                }
            }
        }

        $queryBuilder->join('worksample.scoreType', 'scoreType', 'ON', 'scoreType.id = :scoreTypeName');
        $queryBuilder->setParameter('scoreTypeName', 'In District Scoring');

        $methods = get_class_methods($queryBuilder);
        var_dump('expr');
        var_dump(get_class($queryBuilder->expr()));
        var_dump('getType');
        var_dump($queryBuilder->getType());
        var_dump('getEntityManager');
        var_dump(get_class($queryBuilder->getEntityManager()));
        var_dump('getState');
        var_dump($queryBuilder->getState());
        var_dump('getDQL');
        var_dump($queryBuilder->getDQL());
        var_dump('getQuery');
        var_dump(get_class($queryBuilder->getQuery()));
        var_dump('getRootAlias');
        var_dump($queryBuilder->getRootAlias());
        var_dump('getRootAliases');
        var_dump($queryBuilder->getRootAliases());
        var_dump('getRootEntities');
        var_dump($queryBuilder->getRootEntities());
        var_dump('getParameters');
        var_dump($queryBuilder->getParameters());
        var_dump('getFirstResult');
        var_dump($queryBuilder->getFirstResult());
        var_dump('getMaxResults');
        var_dump($queryBuilder->getMaxResults());
        var_dump('getDQLParts');
        var_dump($queryBuilder->getDQLParts());
        var_dump('__toString');
        var_dump($queryBuilder->__toString());

        $parts = $queryBuilder->getDQLParts();
        if (0 < count($parts['join'])) {
            var_dump($parts['join']);
            var_dump(__LINE__);
            die();
        }

        var_dump($methods);
        die();



        $queryBuilder
            ->andWhere('1 = 1');
        */

        return $queryBuilder;
    }

    protected function applyFilter($queryBuilder, $filter)
    {
        return $queryBuilder;
    }

    public function setConfig( $config )
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }
}