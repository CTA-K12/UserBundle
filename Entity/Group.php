<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Group
 */
abstract class Group
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

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $roles;


    /**
     * Set name
     *
     * @param string $name
     * @return Group
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
     * @return Group
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
     * Add role
     *
     * @param \Mesd\UserBundle\Entity\Role $role
     * @return Group
     */
    public function addRole(\Mesd\UserBundle\Entity\Role $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Get roles as array
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles->toArray();
    }

    /**
     * Get roles as a collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoleCollection()
    {
        return $this->roles;
    }

}
