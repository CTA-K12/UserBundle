<?php

namespace Mesd\UserBundle\Model;


/**
 * Role Interface
 */
interface RoleInterface
{

    /**
     * Set name
     *
     * @param string $name
     * @return Role
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
     * @return Role
     */
    public function setDescription($description);

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription();

}