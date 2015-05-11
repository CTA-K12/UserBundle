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
     * @var array
     */
    protected $entity;

    public function __construct($name, $entities)
    {
        $this->name = $name;
        $this->entity = array();
        foreach($entities as $entity) {
            $this->entity[] = new Entity($entity['name'], $entity['joins']);
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
}
