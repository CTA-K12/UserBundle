<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


abstract class Group implements GroupInterface
{
    protected $id;
    protected $name;
    protected $description;
    protected $roles;

    /**
     * @param RoleInterface $role
     *
     * @return Group
     */
    public function addRole(RoleInterface $role)
    {
        if (!$this->hasRole($role->getName())) {
            $this->roles[] = $role;
        }

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function getRoleNames()
    {
        $names = array();
        foreach ($this->getRoles() as $role) {
            $names[] = $role->getName();
        }

        return $names;
    }

    /**
     * @param string $name
     *
     * @return boolean
     */
    public function hasRole($name)
    {
        return in_array($name, $this->getRoleNames());
    }


    /**
     * @param string $role
     *
     * @return Group
     */
    public function removeRole(RoleInterface $role)
    {
        if ($this->roles->contains($role)) {
            $this->roles->removeElement($role);
        }

        return $this;
    }


    /**
     * @param string $name
     *
     * @return Group
     */
    public function setDescription($name)
    {
        $this->name = $description;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Group
     */
    public function setName($name)
    {
        $this->name = strtoupper($name);

        return $this;
    }

}