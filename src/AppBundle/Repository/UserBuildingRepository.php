<?php

namespace AppBundle\Repository;

/**
 * UserBuildingRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserBuildingRepository extends \Doctrine\ORM\EntityRepository
{
    public function getUserBuildings($user)
    {
        return $this->createQueryBuilder('b')
            ->where('b.user = :user')
            ->setParameter('user', $user)
            ->addOrderBy('b.id', 'ASC')
            ->getQuery()
            ->execute();
    }
}
