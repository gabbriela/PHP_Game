<?php

namespace AppBundle\Repository;

/**
 * UserResourceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserResourceRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUserResources($user)
    {
        return $this->createQueryBuilder('r')
            ->where('r.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->execute();
    }

    public function getUserResourcesById($user, $id)
    {
        return $this->createQueryBuilder('r')
            ->where('r.user = :user')
            ->setParameter('user', $user)
            ->andWhere('r.resourceId = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute()[0];
    }
}
