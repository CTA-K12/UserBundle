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
     * Whether the groups setting is enabled or not
     *
     * @var boolean
     */
    protected $groupsEnabled;

    /**
     * Whether the filters setting is enabled or not
     *
     * @var boolean
     */
    protected $filtersEnabled;

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
     * Gets whether  the groups setting is enabled or not.
     *
     * @return boolean
     */
    public function getGroupsEnabled()
    {
        return $this->groupsEnabled;
    }

    /**
     * Sets whether the groups setting is enabled or not.
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

    /**
     * Gets whether the filters setting is enabled or not.
     *
     * @return boolean
     */
    public function getFiltersEnabled()
    {
        return $this->filtersEnabled;
    }

    /**
     * Sets whether the filters setting is enabled or not.
     *
     * @param boolean $filtersEnabled the filters enabled
     *
     * @return self
     */
    public function setFiltersEnabled($filtersEnabled)
    {
        $this->filtersEnabled = $filtersEnabled;

        return $this;
    }
}