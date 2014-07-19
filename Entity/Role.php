<?php

/*
 * This file is part of the MesdUserBundle package.
 *
 * (c) MESD <https://github.com/MESD>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Mesd\UserBundle\Entity;

abstract class Role implements RoleInterface
{
    protected $id;
    protected $description;
    protected $name;


    public function __construct()
    {

    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = strtoupper($name);

        return $this;
    }


    /**
     * @see Symfony\Component\Security\Core\Role\RoleInterface
     */
    public function getRole()
    {
        return $this->name;
    }

}