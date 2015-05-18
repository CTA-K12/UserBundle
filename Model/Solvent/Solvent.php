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
    protected $bunch;

    public function __construct($unique, $bunches)
    {
        $this->unique = $unique;
        $this->bunch = array();
        $length = count($bunches);
        for ($i = 0; $i < $length; $i++) {
            $this->bunch[] = new Bunch($unique, $bunches[$i]);
        }
    }

    /**
     * Get bunch
     *
     * @return array
     */
    public function getBunch()
    {
        return $this->bunch;
    }

    public function applyToQueryBuilder($queryBuilder, $details)
    {
        $this->bunch[0]->applyToQueryBuilder($queryBuilder, $details);

        return $queryBuilder;
    }

    public function getDetails()
    {
        $details = array();
        foreach($this->bunch as $bunch) {
            $details[] = $bunch->getDetails();
        }

        return '(' . implode(' OR ', $details) . ')';
    }
}
