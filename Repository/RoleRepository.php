<?php

namespace Mesd\UserBundle\Repository;

use Symfony\Component\Security\Core\Role\RoleInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class RoleRepository extends EntityRepository
{

    public function getAllRoles()
    {
        // get the role names only
        $q = $this
            ->createQueryBuilder('r')
            ->getQuery();

        return $q->getResult();
    }
}