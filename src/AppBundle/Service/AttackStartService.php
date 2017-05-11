<?php

namespace AppBundle\Service;


use AppBundle\Entity\Attack;
use AppBundle\Entity\AttackUnits;
use AppBundle\Repository\UserUnitsRepository;

class AttackStartService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function calculateDistance($victim, $attacker)
    {
        $distanceVictim = $victim->getMap()->getPositionX() + $victim->getMap()->getPositionY();
        $distanceAttacker = $attacker->getMap()->getPositionX() + $attacker->getMap()->getPositionY();

        return abs($distanceAttacker - $distanceVictim) * 100;
    }

    public function createNewAttack($victim, $attacker, $distance)
    {
        $attack = new Attack();
        $attack->setStatus("progress");
        $attack->setAttacker($attacker);
        $attack->setVictim($victim);

        $now = new \DateTime('now');

        $attack->setArriveOn($now->add(new \DateInterval('PT' . $distance . 'S')));

        $this->em->persist($attack);
        $this->em->flush();
    }

    public function makeUnitsBusy($unitsInAttack, $attackId)
    {
        foreach ($unitsInAttack as $busyUnitId)
        {
            $unit = $this->em->getRepository('AppBundle:UserUnits')->findUnitById($busyUnitId);
            $unit->setStatus('busy');

            $attackUnit = new AttackUnits();
            $attackUnit->setStatus('progress');
            $attackUnit->setAttack($attackId);
            $attackUnit->setUserUnit($unit);

            $this->em->persist($unit);
            $this->em->persist($attackUnit);
            $this->em->flush();
        }

    }
}