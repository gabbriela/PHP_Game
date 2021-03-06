<?php

namespace AppBundle\Repository;

/**
 * ProgressBuildingLevelRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProgressBuildingLevelRepository extends \Doctrine\ORM\EntityRepository
{
    public function getBuildingsLevelByStatus($user, $status)
    {
        return $this->createQueryBuilder('b')
            ->where('b.status = :status')
            ->setParameter('status', $status)
            ->andWhere('b.user = :user')
            ->setParameter('user', $user)
            ->addOrderBy('b.id', 'ASC')
            ->getQuery()
            ->execute();
    }
}
