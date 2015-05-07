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

    public function applyFilter($queryBuilder)
    {
        $this->getFilters('alice');
        foreach($this->config as $role => $config) {
            var_dump('========');
            var_dump($role, $config['entity']);
            var_dump('--------');
            foreach($config['associations'] as $entity => $field) {
                var_dump($entity, $field);
            }
        }

        $user = $this->securityContext->getToken()->getUser();

        var_dump($user->getRoles());

        $filters = $user->getFilter();
        foreach ($filters as $filter) {
            $solvents = $filter->getSolvent();
            foreach ($solvents as $solvent) {
                $entityName = $solvent['entity'];
                $associations = $solvent['associations'];
                var_dump($entityName);
                foreach ($associations as $association) {
                    foreach ($association as $associationName => $associationId) {
                        var_dump($associationName, $associationId);
                    }
                }
            }
        }

        $queryBuilder->join('worksample.scoreType', 'scoreType', 'ON', 'scoreType.id = :scoreTypeName');
        $queryBuilder->setParameter('scoreTypeName', 'In District Scoring');

        $methods = get_class_methods($queryBuilder);
        var_dump(get_class($queryBuilder->expr()));
        var_dump($queryBuilder->getType());
        var_dump(get_class($queryBuilder->getEntityManager()));
        var_dump($queryBuilder->getState());
        var_dump($queryBuilder->getDQL());
        var_dump(get_class($queryBuilder->getQuery()));
        var_dump($queryBuilder->getRootAlias());
        var_dump($queryBuilder->getRootAliases());
        var_dump($queryBuilder->getRootEntities());
        var_dump($queryBuilder->getParameters());
        var_dump($queryBuilder->getFirstResult());
        var_dump($queryBuilder->getMaxResults());
        var_dump($queryBuilder->getDQLParts());
        var_dump($queryBuilder->__toString());

        $parts = $queryBuilder->getDQLParts();
        if (0 < count($parts['join'])) {
            var_dump($parts['join']);
            die();
        }

        var_dump($methods);
        die();



        $queryBuilder
            ->andWhere('1 = 1');

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

    public function getFilters($username)
    {
        $user = $this->objectManager
            ->getRepository($this->userClass)
            ->findOneByUsername($username);

        if(is_null($user)) {
            throw new \Exception (sprintf("User %s not found.", $username));
        }

        $filters = $this->objectManager
            ->getRepository($this->filterClass)
            ->findByEskillsUser($user);

        // if(0 === count($filters)) {
        //     throw new \Exception (sprintf("Filters for %s not found.", $username));
        // }

        return $filters;
    }
}