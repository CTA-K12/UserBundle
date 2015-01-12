<?php

namespace Mesd\UserBundle\Listeners\Doctrine;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;

/**
 * A listener that watches for when the user entity metadata is loaded by doctrine to set the is using groups setting
 */
class UserLoadMetadataListener
{
    ///////////////
    // VARIABLES //
    ///////////////

    /**
     * Whether the the groups setting is enabled or not
     *
     * @var boolean
     */
    protected $groupsEnabled;

    //////////////
    // LISTENER //
    //////////////


    /**
     * loadClassMetadata listener callback
     *
     * @param  LoadClassMetadataEventArgs $args The event args
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $args) {
        //We only care about the user entity
        if ('Mesd\UserBundle\Entity\User' === $args->getClassMetadata()->getName()) {
            // Reflection class is null when generating entities - may be fixed in newer doctrine.
            if (null !== $args->getClassMetadata()->getReflectionClass()) {
                //Set the static property groups enabled in the configuration
                $args->getClassMetadata()->getReflectionClass()->getProperty('groupsEnabled')->setValue($this->groupsEnabled);
            }
        }
    }


    /////////////////////////
    // GETTERS AND SETTERS //
    /////////////////////////


    /**
     * Gets the Whether the the groups setting is enabled or not.
     *
     * @return boolean
     */
    public function getGroupsEnabled()
    {
        return $this->groupsEnabled;
    }

    /**
     * Sets the Whether the the groups setting is enabled or not.
     *
     * @param boolean $groupsEnabled the groups enabled
     *
     * @return self
     */
    public function setGroupsEnabled($groupsEnabled)
    {
        $this->groupsEnabled = $groupsEnabled;

        return $this;
    }
}