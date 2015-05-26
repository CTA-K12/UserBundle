<?php

namespace Mesd\UserBundle\Model;

use Mesd\UserBundle\Model\RoleInterface;

/**
 * Group Interface
 */
interface GroupInterface
{

    /**
     * Set name
     *
     * @param string $name
     * @return Group
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
     * @return Group
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

    /**
     * Add role
     *
     * @param RoleInterface $role
     * @return Group
     */
    public function addRole(RoleInterface $role);

    /**
     * Get roles as array
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles();

    /**
     * Get roles as a collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole();

    /**
     * Get role names as array
     *
     * @return array
     */
    public function getRoleNames();

    /**
     * Remove role
     *
     * @param RoleInterface $role
     * @return User
     */
    public function removeRole(RoleInterface $role);

}