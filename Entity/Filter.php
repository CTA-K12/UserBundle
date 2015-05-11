<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mesd\UserBundle\Model\FilterInterface;
use Mesd\UserBundle\Model\Solvent\Solvent;

/**
 * Filter
 */
abstract class Filter implements FilterInterface
{
    protected $id;

    /**
     * @var array
     */
    protected $solvent;



    public function __construct()
    {
    }

    public function __toString()
    {
        return (string) $this->getSolvent();
    }

    /**
     * Set solvent
     *
     * @param array $solvent
     * @return Filter
     */
    public function setSolvent($solvent)
    {
        $this->solvent = $solvent;

        return $this;
    }

    /**
     * Get solvent
     *
     * @return array
     */
    public function getSolvent()
    {
        return $this->solvent;
    }

    /**
     * Get getSolventWrappers
     *
     * @return array
     */
    public function getSolventWrappers()
    {
        $solventWrappers = array();
        foreach ($this->getSolvent() as $roleName => $entities) {
            $solventWrappers[] = new Solvent($roleName, $entities);
        }
        return $solventWrappers;
    }
}
