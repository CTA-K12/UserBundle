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
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $solvent;

    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Filter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
        $i = 0;
        foreach ($this->getSolvent() as $solvent) {
            $solventWrappers[] = new Solvent('solvent' . $i, $solvent);
            $i++;
        }
        return $solventWrappers;
    }
}
