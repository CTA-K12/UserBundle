<?php

namespace Mesd\UserBundle\Model;

use Mesd\UserBundle\Model\FilterInterface;

/**
 * FilterCategory Interface
 */
interface FilterCategoryInterface
{

    /**
     * Set name
     *
     * @param string $name
     * @return FilterCategory
     */
    public function setName($name);

    /**
     * Get name
     *
     * @return string
     */
    public function getName();

    /**
     * Set description
     *
     * @param string $description
     * @return FilterCategory
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Add filter
     *
     * @param FilterInterface $filter
     * @return FilterCategory
     */
    public function addFilter(FilterInterface $filter);

    /**
     * Remove filter
     *
     * @param FilterInterface $filter
     * @return User
     */
    public function removeFilter(FilterInterface $filter);

    /**
     * Get roles as a collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilter();

}