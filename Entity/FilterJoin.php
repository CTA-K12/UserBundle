<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilterJoin
 */
class FilterJoin
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $value;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $filterCell;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $filterAssociation;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filterCell = new \Doctrine\Common\Collections\ArrayCollection();
        $this->filterAssociation = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set value
     *
     * @param integer $value
     * @return FilterJoin
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer 
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return FilterJoin
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
     * Add filterCell
     *
     * @param \Mesd\UserBundle\Entity\FilterCell $filterCell
     * @return FilterJoin
     */
    public function addFilterCell(\Mesd\UserBundle\Entity\FilterCell $filterCell)
    {
        $this->filterCell[] = $filterCell;

        return $this;
    }

    /**
     * Remove filterCell
     *
     * @param \Mesd\UserBundle\Entity\FilterCell $filterCell
     */
    public function removeFilterCell(\Mesd\UserBundle\Entity\FilterCell $filterCell)
    {
        $this->filterCell->removeElement($filterCell);
    }

    /**
     * Get filterCell
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilterCell()
    {
        return $this->filterCell;
    }

    /**
     * Add filterAssociation
     *
     * @param \Mesd\UserBundle\Entity\FilterAssociation $filterAssociation
     * @return FilterJoin
     */
    public function addFilterAssociation(\Mesd\UserBundle\Entity\FilterAssociation $filterAssociation)
    {
        $this->filterAssociation[] = $filterAssociation;

        return $this;
    }

    /**
     * Remove filterAssociation
     *
     * @param \Mesd\UserBundle\Entity\FilterAssociation $filterAssociation
     */
    public function removeFilterAssociation(\Mesd\UserBundle\Entity\FilterAssociation $filterAssociation)
    {
        $this->filterAssociation->removeElement($filterAssociation);
    }

    /**
     * Get filterAssociation
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilterAssociation()
    {
        return $this->filterAssociation;
    }
}
