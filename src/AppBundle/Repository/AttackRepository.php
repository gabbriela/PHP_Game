<?php

namespace AppBundle\Repository;

/**
 * AttackRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AttackRepository extends \Doctrine\ORM\EntityRepository
{
    public function getAttack($attacker, $victim, $status)
    {
        return $this->createQueryBuilder('a')
            ->where('a.attacker = :attacker')
            ->setParameter('attacker', $attacker)
            ->andWhere('a.victim = :victim')
            ->setParameter('victim', $victim)
            ->andWhere('a.status = :status')
            ->setParameter('status', $status)
            ->addOrderBy('a.id', 'DESC')
            ->getQuery()->execute();
    }

    public function getAttackerAttacks ($user, $status)
    {
        return $this->createQueryBuilder('a')
            ->where('a.attacker = :attacker')
            ->setParameter('attacker', $user)
            ->andWhere('a.status = :status')
            ->setParameter('status', $status)
            ->getQuery()->execute();
    }

    public function getVictimAttacks ($user, $status)
    {
        return $this->createQueryBuilder('a')
            ->where('a.victim = :user')
            ->setParameter('user', $user)
            ->andWhere('a.status = :status')
            ->setParameter('status', $status)
            ->getQuery()->execute()[0];
    }
}
