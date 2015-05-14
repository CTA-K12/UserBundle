<?php

namespace Mesd\UserBundle\Model\Or;

/**
 * Or
 */
class Or {

    /**
     * @var string
     */
    protected $unique;

    /**
     * @var array
     */
    protected $entity;

    public function __construct($unique, $entities)
    {
        $this->entity = array();
        $length = count($entities);
        for ($i = 0; $i < $length; $i++) {
            $this->entity[] = new Entity($entities[$i]['name'], $unique . 'or' . $i, $entities[$i]['joins']);
        }
    }

    /**
     * Get entity
     *
     * @return array
     */
    public function getEntity()
    {
        return $this->entity;
    }

    public function applyToQueryBuilder($queryBuilder)
    {
        foreach ($this->entity as $entity) {
            $entity->applyToQueryBuilder($queryBuilder);
        }

        return $queryBuilder;
    }
}
