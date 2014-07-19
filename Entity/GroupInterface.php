<?php

namespace Mesd\UserBundle\Entity;

interface GroupInterface
{
    /**
     * @param RoleInterface $role
     *
     * @return self
     */
    public function addRole(RoleInterface $role);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

  /**
     * Indicates whether the group contains the specified role or not.
     *
     * @param string $name Name of the role
     *
     * @return Boolean
     */
    public function hasRole($role);

    /**
     * @return Collection
     */
    public function getRoles();

    /**
     * @param RoleInterface $role
     *
     * @return self
     */
    public function removeRole(RoleInterface $role);

    /**
     * @param string $description
     *
     * @return self
     */
    public function setDescription($description);

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name);

}
