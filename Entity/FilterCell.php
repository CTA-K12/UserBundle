<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilterCell
 */
class FilterCell
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $filterRow;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $filterJoin;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filterRow = new \Doctrine\Common\Collections\ArrayCollection();
        $this->filterJoin = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return FilterCell
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
     * Add filterRow
     *
     * @param \Mesd\UserBundle\Entity\FilterRow $filterRow
     * @return FilterCell
     */
    public function addFilterRow(\Mesd\UserBundle\Entity\FilterRow $filterRow)
    {
        $this->filterRow[] = $filterRow;

        return $this;
    }

    /**
     * Remove filterRow
     *
     * @param \Mesd\UserBundle\Entity\FilterRow $filterRow
     */
    public function removeFilterRow(\Mesd\UserBundle\Entity\FilterRow $filterRow)
    {
        $this->filterRow->removeElement($filterRow);
    }

    /**
     * Get filterRow
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilterRow()
    {
        return $this->filterRow;
    }

    /**
     * Add filterJoin
     *
     * @param \Mesd\UserBundle\Entity\FilterJoin $filterJoin
     * @return FilterCell
     */
    public function addFilterJoin(\Mesd\UserBundle\Entity\FilterJoin $filterJoin)
    {
        $this->filterJoin[] = $filterJoin;

        return $this;
    }

    /**
     * Remove filterJoin
     *
     * @param \Mesd\UserBundle\Entity\FilterJoin $filterJoin
     */
    public function removeFilterJoin(\Mesd\UserBundle\Entity\FilterJoin $filterJoin)
    {
        $this->filterJoin->removeElement($filterJoin);
    }

    /**
     * Get filterJoin
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilterJoin()
    {
        return $this->filterJoin;
    }
}
