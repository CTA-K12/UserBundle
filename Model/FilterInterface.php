<?php

namespace Mesd\UserBundle\Model;

/**
 * Filter Interface
 */
interface FilterInterface
{

    /**
     * Set solvent
     *
     * @param array $solvent
     * @return Solvent
     */
    public function setSolvent($solvent);

    /**
     * Get solvent
     *
     * @return array
     */
    public function getSolvent();
}