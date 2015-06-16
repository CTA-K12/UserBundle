<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FilterEntity
 */
class FilterEntity
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
    private $databaseName;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $filterAssociation;

    /**
     * Constructor
     */
    public function __construct()
    {
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
     * Set name
     *
     * @param string $name
     * @return FilterEntity
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
     * Set databaseName
     *
     * @param string $databaseName
     * @return FilterEntity
     */
    public function setDatabaseName($databaseName)
    {
        $this->databaseName = $databaseName;

        return $this;
    }

    /**
     * Get databaseName
     *
     * @return string 
     */
    public function getDatabaseName()
    {
        return $this->databaseName;
    }

    /**
     * Add filterAssociation
     *
     * @param \Mesd\UserBundle\Entity\FilterAssociation $filterAssociation
     * @return FilterEntity
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
