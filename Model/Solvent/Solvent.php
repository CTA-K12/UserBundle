<?php

namespace Mesd\UserBundle\Model\Solvent;

/**
 * Solvent
 */
class Solvent {

    /**
     * @var string
     */
    protected $unique;

    /**
     * @var array
     */
    protected $or;

    public function __construct($unique, $ors)
    {
        $this->or = array();
        $length = count($ors);
        for ($i = 0; $i < $length; $i++) {
            $this->or[] = new Entity($ors[$i], $unique . 'or' . $i, $ors[$i]);
        }
    }

    /**
     * Get or
     *
     * @return array
     */
    public function getOr()
    {
        return $this->or;
    }

    public function applyToQueryBuilder($queryBuilder)
    {
        foreach ($this->or as $or) {
            $or->applyToQueryBuilder($queryBuilder);
        }

        return $queryBuilder;
    }
}
