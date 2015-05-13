<?php

namespace Mesd\UserBundle\Model\Solvent;

/**
 * Solvent
 */
class Solvent {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $unique;

    /**
     * @var array
     */
    protected $entity;

    public function __construct($name, $unique, $entities)
    {
        $this->name = $name;
        $this->entity = array();
        $length = count($entities);
        for ($i = 0; $i < $length; $i++) {
            $this->entity[] = new Entity($entities[$i]['name'], $unique . 'entity' . $i, $entities[$i]['joins']);
        }
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
