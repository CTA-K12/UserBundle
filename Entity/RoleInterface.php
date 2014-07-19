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

use Symfony\Component\Security\Core\Role\RoleInterface as CoreRoleInterface;


interface RoleInterface extends CoreRoleInterface
{

    /**
     * @return integer
     */
    public function getId();

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     *
     * @return self
     */
    public function setDescription($name);

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name);

}