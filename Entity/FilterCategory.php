<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mesd\UserBundle\Model\FilterCategoryInterface;
use Mesd\UserBundle\Model\FilterInterface;

/**
 * FilterCategory
 */
abstract class FilterCategory implements FilterCategoryInterface
{
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;


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
     * @return FilterCategory
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
     * Set description
     *
     * @param string $description
     * @return FilterCategory
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add filter
     *
     * @param FilterInterface $filter
     * @return FilterCategory
     */
    public function addFilter(FilterInterface $filter)
    {
        $this->filter[] = $filter;
    
        return $this;
    }

    /**
     * Remove filter
     *
     * @param FilterInterface $filter
     */
    public function removeFilter(FilterInterface $filter)
    {
        $this->filter->removeElement($filter);
    }

    /**
     * Get filter
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilter()
    {
        return $this->filter;
    }
}
