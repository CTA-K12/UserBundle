<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mesd\UserBundle\Model\FilterInterface;

/**
 * Filter
 */
abstract class Filter implements FilterInterface
{
    protected $id;

    /**
     * @var array
     */
    protected $filter;



    public function __construct()
    {
    }

    public function __toString()
    {
        return (string) $this->getFilter();
    }

    /**
     * Set filter
     *
     * @param array $filter
     * @return Filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }

    /**
     * Get filter
     *
     * @return array
     */
    public function getFilter()
    {
        return $this->filter;
    }
}