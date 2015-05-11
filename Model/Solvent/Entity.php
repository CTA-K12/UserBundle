<?php

namespace Mesd\UserBundle\Model\Solvent;

/**
 * Entity
 */
class Entity {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $join;

    public function __construct($name, $joins)
    {
        $this->name = $name;
        $this->join = array();
        foreach($joins as $joinName => $joinId) {
            $this->join[] = new Join($joinName, $joinId);
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
     * Get join
     *
     * @return array
     */
    public function getJoin()
    {
        return $this->join;
    }
}
