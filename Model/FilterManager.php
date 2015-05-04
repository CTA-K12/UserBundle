<?php

namespace Mesd\UserBundle\Model;

class FilterManager {

    private $objectManager;
    private $filterClass;
    private $roleClass;
    private $userClass;
    private $config;

    public function __construct($objectManager, $userClass, $roleClass, $filterClass)
    {
         $this->objectManager = $objectManager->getManager();
         $this->userClass     = $userClass;
         $this->roleClass     = $roleClass;
         $this->filterClass   = $filterClass;
    }

    public function applyFilter($queryBuilder)
    {
        // foreach($this->config as $role => $config) {
        //     var_dump('========');
        //     var_dump($role, $config['filtrate']);
        //     var_dump('--------');
        //     foreach($config['solvents'] as $entity => $field) {
        //         var_dump($entity, $field);
        //     }
        // }
        // var_dump($queryBuilder->getQuery()->getDql());
        // die();

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