<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilterAssociation
 */
class FilterAssociation
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $trail;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $filterJoin;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $filterEntity;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filterJoin = new \Doctrine\Common\Collections\ArrayCollection();
        $this->filterEntity = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return FilterAssociation
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
     * Set trail
     *
     * @param string $trail
     * @return FilterAssociation
     */
    public function setTrail($trail)
    {
        $this->trail = $trail;

        return $this;
    }

    /**
     * Get trail
     *
     * @return string 
     */
    public function getTrail()
    {
        return $this->trail;
    }

    /**
     * Add filterJoin
     *
     * @param \Mesd\UserBundle\Entity\FilterJoin $filterJoin
     * @return FilterAssociation
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

    /**
     * Add filterEntity
     *
     * @param \Mesd\UserBundle\Entity\FilterEntity $filterEntity
     * @return FilterAssociation
     */
    public function addFilterEntity(\Mesd\UserBundle\Entity\FilterEntity $filterEntity)
    {
        $this->filterEntity[] = $filterEntity;

        return $this;
    }

    /**
     * Remove filterEntity
     *
     * @param \Mesd\UserBundle\Entity\FilterEntity $filterEntity
     */
    public function removeFilterEntity(\Mesd\UserBundle\Entity\FilterEntity $filterEntity)
    {
        $this->filterEntity->removeElement($filterEntity);
    }

    /**
     * Get filterEntity
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilterEntity()
    {
        return $this->filterEntity;
    }
}
