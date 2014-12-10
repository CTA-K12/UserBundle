<?php

namespace Mesd\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Util\SecureRandom;
use Mesd\UserBundle\Model\GroupInterface;
use Mesd\UserBundle\Model\RoleInterface;
use Mesd\UserBundle\Model\UserInterface;
use Mesd\UserBundle\Entity\Role;

/**
 * User
 */
abstract class User implements UserInterface
{
    protected $id;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var boolean
     */
    protected $enabled;

    /**
     * @var string
     */
    protected $salt;

    /**
     * @var string
     */
    protected $password;

    /**
     * This property is never persisted
     *
     * @var string
     */
    protected $plainPassword;

    /**
     * @var \DateTime
     */
    protected $lastLogin;

    /**
     * @var boolean
     */
    protected $locked;

    /**
     * @var boolean
     */
    protected $expired;

    /**
     * @var \DateTime
     */
    protected $expiresAt;

    /**
     * @var string
     */
    protected $confirmationToken;

    /**
     * @var \DateTime
     */
    protected $passwordRequestedAt;

    /**
     * @var boolean
     */
    protected $credentialsExpired;

    /**
     * @var \DateTime
     */
    protected $credentialsExpireAt;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $role;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    protected $group;


    public function __construct()
    {
        $this->salt               = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
        $this->enabled            = true;
        $this->locked             = false;
        $this->expired            = false;
        $this->credentialsExpired = false;

        $this->role  = new ArrayCollection();
        $this->group = new ArrayCollection();
    }


    public function __toString()
    {
        return (string) $this->getUsername();
    }


    /**
     * Get getId
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = mb_convert_case($username, MB_CASE_LOWER, mb_detect_encoding($username));

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = mb_convert_case($email, MB_CASE_LOWER, mb_detect_encoding($email));

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set plainPassword
     *
     * @param string $plainPassword
     * @return User
     */
    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * Set lastLogin
     *
     * @param \DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }

    /**
     * Get lastLogin
     *
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }

    /**
     * Set expired
     *
     * @param boolean $expired
     * @return User
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;

        return $this;
    }

    /**
     * Get expired
     *
     * @return boolean
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * Set expiresAt
     *
     * @param \DateTime $expiresAt
     * @return User
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    /**
     * Get expiresAt
     *
     * @return \DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * Set confirmationToken
     *
     * @param string $confirmationToken
     * @return User
     */
    public function setConfirmationToken($confirmationToken)
    {
        $this->confirmationToken = $confirmationToken;

        return $this;
    }


    public function generateConfirmationToken()
    {
        $generator = new SecureRandom();
        $random = $generator->nextBytes(32);

        $this->setConfirmationToken(
            rtrim(strtr(base64_encode($random), '+/', '-_'), '=')
        );

        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * Set passwordRequestedAt
     *
     * @param \DateTime $passwordRequestedAt
     * @return User
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;

        return $this;
    }

    /**
     * Get passwordRequestedAt
     *
     * @return \DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * Is password request non-expired
     *
     * @param integer $ttl
     * @return \DateTime
     */
    public function isPasswordRequestNonExpired($ttl)
    {
        return $this->getPasswordRequestedAt() instanceof \DateTime &&
               $this->getPasswordRequestedAt()->getTimestamp() + $ttl > time();
    }

    /**
     * Set credentialsExpired
     *
     * @param boolean $credentialsExpired
     * @return User
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;

        return $this;
    }

    /**
     * Get credentialsExpired
     *
     * @return boolean
     */
    public function getCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * Set credentialsExpireAt
     *
     * @param \DateTime $credentialsExpireAt
     * @return User
     */
    public function setCredentialsExpireAt($credentialsExpireAt)
    {
        $this->credentialsExpireAt = $credentialsExpireAt;

        return $this;
    }

    /**
     * Get credentialsExpireAt
     *
     * @return \DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }



    /**
     * Role Methods
     *
     */

    /**
     * Add role
     *
     * @param RoleInterface
     * @return User
     */
    public function addRole(RoleInterface $role)
    {
        $this->role[] = $role;

        return $this;
    }

    /**
     * Get roles as array
     *
     * This method is required by the Symfony2 UserInterface
     * and is called at user login time.
     *
     * Symfony2 expects a user to have at least one role,
     * so ROLE_DEFUALT is always added by this method.
     *
     * @return array
     */
    public function getRoles()
    {
        $role   = $this->getRoleNames();
        $role[] = 'ROLE_DEFAULT';

        return $role;
    }

    /**
     * Get Role
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRole()
    {
        $role =  $this->role->toArray();

        if (0 < count($this->getGroup())) {
            foreach ($this->getGroup() as $group) {
                $role = array_merge($role, $group->getRole()->toArray());
            }
        }

        $role = array_unique($role);

        return new ArrayCollection($role);
    }

    /**
     * Get RoleFromGroups
     *
     * This method does not load roles included from groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoleFromGroups()
    {
        $role = array();

        if (0 < count($this->getGroup())) {
            foreach ($this->getGroup() as $group) {
                $role = array_merge($role, $group->getRole()->toArray());
            }
        }

        $role = array_unique($role);

        return new ArrayCollection($role);
    }

    /**
     * Get RoleStandalone
     *
     * This method does not load roles included from groups
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoleStandalone()
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
     * Get role names from groups as array
     *
     * This method does not load standalone roles
     *
     * @return array
     */
    public function getRoleNamesFromGroups()
    {
        $names = array();
        foreach ($this->getRoleFromGroups() as $role) {
            $names[] = $role->getName();
        }

        return $names;
    }

    /**
     * Get stand alone role names as array
     *
     * This method does not load roles included from groups
     *
     * @return array
     */
    public function getRoleNamesStandalone()
    {
        $names = array();
        foreach ($this->getRoleStandalone() as $role) {
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
        if($this->role->contains($role)) {
            $this->role->removeElement($role);
        }

        return $this;
    }



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
    public function addGroup(GroupInterface $group)
    {
        $this->group[] = $group;

        return $this;
    }

    /**
     * Get groups as array
     *
     * @return array
     */
    public function getGroups()
    {

        return $this->group->toArray();
    }

    /**
     * Get groups as Collection
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Get group names as array
     *
     * @return array
     */
    public function getGroupNames()
    {
        $names = array();
        foreach ($this->getGroup() as $group) {
            $names[] = $group->getName();
        }

        return $names;
    }

    /**
     * Remove group
     *
     * @param GroupInterface $group
     * @return User
     */
    public function removeGroup(GroupInterface $group)
    {
        if ($this->group->contains($group)) {
            $this->group->removeElement($group);
        }

        return $this;
    }



    /**
     * AdvancedUserInterface additionaly required methods
     *
     */

    /**
     * Removes sensitive data from the user.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }


    public function isAccountNonExpired()
    {
        if (true === $this->expired) {
            return false;
        }

        if (null !== $this->expiresAt && $this->expiresAt->getTimestamp() < time()) {
            return false;
        }

        return true;
    }

    public function isAccountNonLocked()
    {
        return !$this->locked;
    }

    public function isCredentialsNonExpired()
    {
        if (true === $this->credentialsExpired) {
            return false;
        }

        if (null !== $this->credentialsExpireAt && $this->credentialsExpireAt->getTimestamp() < time()) {
            return false;
        }

        return true;
    }

    public function isEnabled()
    {
        return $this->enabled;
    }



    /**
     * Serializable Required Methods
     *
     */

    /**
     * Serializes the user.
     *
     * The serialized data have to contain the fields used by the equals method and the username.
     *
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->password,
            $this->salt,
            $this->username,
            $this->expired,
            $this->locked,
            $this->credentialsExpired,
            $this->enabled,
            $this->id,
        ));
    }

    /**
     * Unserializes the user.
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $data = unserialize($serialized);

        list(
            $this->password,
            $this->salt,
            $this->username,
            $this->expired,
            $this->locked,
            $this->credentialsExpired,
            $this->enabled,
            $this->id
        ) = $data;
    }

}