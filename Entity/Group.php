<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Mesd\UserBundle\Model\GroupInterface;
use Mesd\UserBundle\Model\RoleInterface;

/**
 * Group
 */
abstract class Group implements GroupInterface
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
    protected $role;


    public function __construct()
    {
        $this->role  = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Group
     */
    public function setName($name)
    {
        $this->name = strtoupper($name);

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
     * @param RoleInterface $role
     * @return Group
     */
    public function addRole(RoleInterface $role)
    {
        $this->role[] = $role;

        return $this;
    }

    /**
     * Get roles as array
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->role->toArray();
    }

    /**
     * Get roles as a collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Get role names as array
     *
     * @return array
     */
    public function getRoleNames()
    {
        $names = array();
        foreach ($this->getRole() as $role) {
            $names[] = $role->getName();
        }

        return $names;
    }

    /**
     * Remove role
     *
     * @param RoleInterface $role
     * @return User
     */
    public function removeRole(RoleInterface $role)
    {
        if ($this->role->contains($role)) {
            $this->role->removeElement($role);
        }

        return $this;
    }

}