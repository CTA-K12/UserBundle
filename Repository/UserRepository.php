<?php

namespace Mesd\UserBundle\Repository;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository implements UserProviderInterface
{

    private $authCredentialType;

    function __construct($doctrine, $userClass, $authCredentialType) {
        parent::__construct($doctrine->getManager(), new ClassMetadata($userClass));
        $this->authCredentialType = $authCredentialType;
    }


    public function loadUserByUsername($authCredential)
    {
        $authCredential = mb_convert_case($authCredential, MB_CASE_LOWER, mb_detect_encoding($authCredential));

        $q = $this->createQueryBuilder('u');

        if ('email' == $this->authCredentialType) {
            $q->where('u.email = :email')
              ->setParameter('email', $authCredential);
        }
        elseif ('username_email' == $this->authCredentialType) {
            $q->where('u.username = :username OR u.email = :email')
              ->setParameter('username', $authCredential)
              ->setParameter('email', $authCredential);
        }
        else {
            $q->where('u.username = :username')
              ->setParameter('username', $authCredential);
        }

        $result = $q->getQuery();

        try {
            // The Query::getSingleResult() method throws an exception
            // if there is no record matching the criteria.
            $user = $result->getSingleResult();
        } catch (NoResultException $e) {
            $message = sprintf(
                'Unable to find an active MesdUserBundle:User object identified by "%s".',
                $authCredential
            );
            throw new UsernameNotFoundException($message, 0, $e);
        } catch (\Exception $e) {
            $message = sprintf(
                'Unable to process authentication.'
            );
            throw new AuthenticationServiceException($message, 0, $e);

        }

        return $user;
    }


    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(
                sprintf(
                    'Instances of "%s" are not supported.',
                    $class
                )
            );
        }

        return $this->find($user->getId());
    }


    public function supportsClass($class)
    {
        return $this->getEntityName() === $class
            || is_subclass_of($class, $this->getEntityName());
    }
}