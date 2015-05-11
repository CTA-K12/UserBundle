<?php

namespace Mesd\UserBundle\Model\Solvent;

/**
 * Join
 */
class Join {

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $id;

    public function __construct($name, $id)
    {
        $this->name = $name;
        $this->id = (int)$id;
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
