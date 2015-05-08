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
        $user = $this->securityContext->getToken()->getUser();

        foreach($this->config as $role => $config) {
            var_dump('========');
            var_dump($role, $config['entity']);
            var_dump('--------');
            foreach($config['associations'] as $entity => $field) {
                var_dump($entity, $field);
            }
        }


        var_dump($user->getRoles());

        $filters = $user->getFilter();
        foreach ($filters as $filter) {
            $solvents = $filter->getSolvent();
            foreach ($solvents as $solventId => $solvent) {
                var_dump('solventId', $solventId);
                foreach ($entities as $entityName => $associations) {
                    var_dump('entityName', $entityName);
                    // foreach ($associations as $associationName => $id) {
                    //     var_dump('associationName', $associationName);
                    //     var_dump('id', $id);
                    // }
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
}