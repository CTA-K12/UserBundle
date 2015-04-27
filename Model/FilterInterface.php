<?php

namespace Mesd\UserBundle\Model;

/**
 * Filter Interface
 */
interface FilterInterface
{

    /**
     * Set filter
     *
     * @param array $filter
     * @return Filter
     */
    public function setFilter($filter);

    /**
     * Get filter
     *
     * @return array
     */
    public function getFilter();
}