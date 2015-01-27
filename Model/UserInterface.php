<?php

namespace Mesd\UserBundle\Model;

use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Mesd\UserBundle\Model\GroupInterface;
use Mesd\UserBundle\Model\RoleInterface;

/**
 * User Interface
 */
interface UserInterface extends AdvancedUserInterface, \Serializable
{

    const ROLE_DEFAULT = 'ROLE_USER';

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username);

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return User
     */
    public function setEnabled($enabled);

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled();

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt);


    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password);


    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword($password);

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword();

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin);

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin();

    /**
     * Set locked
     *
     * @param boolean $locked
     * @return User
     */
    public function setLocked($locked);

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked();

    /**
     * Set expired
     *
     * @param boolean $expired
     * @return User
     */
    public function setExpired($expired);

    /**
     * Get expired
     *
     * @return boolean
     */
    public function getExpired();

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     * @return User
     */
    public function setExpiresAt($expiresAt);

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt();

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken);

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken();

    /**
     * Set passwordRequestedAt
     *
     * @param \DateTime $passwordRequestedAt
     * @return User
     */
    public function setPasswordRequestedAt($passwordRequestedAt);

    /**
     * Get passwordRequestedAt
     *
     * @return \DateTime
     */
    public function getPasswordRequestedAt();

    /**
     * Set credentialsExpired
     *
     * @param boolean $credentialsExpired
     * @return User
     */
    public function setCredentialsExpired($credentialsExpired);

    /**
     * Get credentialsExpired
     *
     * @return boolean
     */
    public function getCredentialsExpired();

    /**
     * Set credentialsExpireAt
     *
     * @param \DateTime $credentialsExpireAt
     * @return User
     */
    public function setCredentialsExpireAt($credentialsExpireAt);

    /**
     * Get credentialsExpireAt
     *
     * @return \DateTime
     */
    public function getCredentialsExpireAt();



    /**
     * Role Methods
     *
     */

    /**
     * Add role
     *
     * @param  string $role
     * @return User
     */
    public function addRole(RoleInterface $role);

    /**
     * Get role as collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole();

    /**
     * Get role as collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    //public function getRole();

    /**
     * Get role names as array
     *
     * @return array
     */
    public function getRoleNames();

    /**
     * Remove role
     *
     * @param  RoleInterface $role
     * @return User
     */
    public function removeRole(RoleInterface $role);



    /**
     * Group Methods
     *
     */

    /**
     * Add group
     *
     * @param GroupInterface $group
     * @return User
     */
    public function addGroup(GroupInterface $group);

    /**
     * Get groups as array
     *
     * @return array
     */
    public function getGroups();

    /**
     * Get groups as Collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroup();

    /**
     * Get group names as array
     *
     * @return array
     */
    public function getGroupNames();

    /**
     * Remove group
     *
     * @param GroupInterface $group
     * @return User
     */
    public function removeGroup(GroupInterface $group);

}