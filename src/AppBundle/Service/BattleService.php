<?php

namespace AppBundle\Service;


use AppBundle\Entity\Attack;
use AppBundle\Entity\BattleReport;
use Symfony\Component\DependencyInjection\Container;

/**
 * @property  Container container
 */
class BattleService
{
    private $em;
    private $progressService;

    public function __construct($em)
    {
        $this->em = $em;
        $this->progressService = new ProgressService($em);
    }

    public function updateAttacks($user)
    {
        $userAttacks = $this->em->getRepository('AppBundle:Attack')->getAttackerAttacks($user, "progress");

        $now = new \DateTime('now');

        //Update attacks
        foreach ($userAttacks as $uattack){
            if ($now >= $uattack->getArriveOn()) {

                //finish the battle
                $uattack->setStatus('ready');
                $this->em->persist($uattack);

                $attacker = $uattack->getAttacker();
                $victim = $uattack->getVictim();

                $attackerLife = 0;
                $attackerDmg = 0;
                $victimLife = 0;
                $victimDmg = 0;

                $attackItself = $this->em->getRepository('AppBundle:Attack')->getAttack($attacker, $victim, "progress");

                $attackerUnits = $this->em->getRepository('AppBundle:AttackUnits')->getAttackUnits($attackItself, "progress");

                //calculate attacker life and dmg
                foreach ($attackerUnits as $au){
                    $attackerDmg += $au->getUserUnit()->getUnit()->getDamage();
                    $attackerLife += $au->getUserUnit()->getLifePoints();

                    $au->setStatus('ready');
                    $unitId = $au->getUserUnitId();
                    $auUserUnit = $this->em->getRepository('AppBundle:UserUnits')->findUnitById($unitId);

                    $rndAuLife = random_int(-20, $auUserUnit->getLifePoints());

                    $auUserUnit->setLifePoints($rndAuLife);
                    if($rndAuLife <= 0){
                        $auUserUnit->setStatus('dead');
                    } else {
                        $auUserUnit->setStatus('free');
                    }

                    $this->em->persist($au);
                    $this->em->persist($auUserUnit);
                    $this->em->flush();
                }

                //update units
                $this->progressService->updateUnits($attacker);
                $this->progressService->updateUnits($victim);

                $victimUnits = $this->em->getRepository('AppBundle:UserUnits')->getUserUnitsByStatus($victim, "free");

                //calculate victim life and dmg
                foreach ($victimUnits as $vu){
                    $victimDmg += $vu->getUnit()->getDamage();
                    $victimLife += $vu->getLifePoints();

                    $rndAuLife = random_int(-20, $vu->getLifePoints());
                    $vu->setLifePoints($rndAuLife);
                    if($rndAuLife <= 0){
                        $vu->setStatus('dead');
                    } else {
                        $vu->setStatus('free');
                    }

                    $this->em->persist($vu);
                    $this->em->flush();
                }

                $batReport = new BattleReport();
                $batReport->setAttack($uattack);

                //default - attacker wins, if attDmg < 60% of victims life - victim wins
                $foodPercent = random_int(10, 50)/100;
                $woodPercent = random_int(10, 60)/100;
                $stonePercent = random_int(10, 70)/100/100;
                $goldPercent = random_int(10, 60)/100;

                $stolenFood = 0;
                $stolenWood = 0;
                $stolenStone = 0;
                $stolenGold = 0;

                $winner = $attacker;
                $looser = $victim;

                if($attackerDmg < ($victimLife * 0.6) && $victimDmg >= ($attackerLife * 0.5)){
                    $winner = $victim;
                    $looser = $attacker;

                } else {
                    //random winner

                    $rnd = random_int(1, 2);
                    if($rnd === 1){$winner = $attacker; $looser = $victim;}
                    else{$winner = $victim; $looser = $attacker;}
                }


                //Resources
                $looserResources = $this->em->getRepository('AppBundle:UserResource')->getUserResources($looser);

                foreach ($looserResources as $looserRes) {
                    $name = $looserRes->getResources()->getName();

                    if ($name == "food") {
                        $stolenFood = (int)($looserRes->getAmount() * $foodPercent);
                        $looserRes->setAmount((int)($looserRes->getAmount() - $stolenFood));

                        $winnerFood = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($winner, 1);

                        $winnerFood->setAmount((int)($winnerFood->getAmount() + $stolenFood));
                        $this->em->persist($winnerFood);

                    } else if ($name == "wood") {
                        $stolenWood = (int)($looserRes->getAmount() * $woodPercent);
                        $looserRes->setAmount((int)($looserRes->getAmount() - $stolenWood));

                        $winnerWood = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($winner, 2);
                        $winnerWood->setAmount((int)($winnerWood->getAmount() + $stolenWood));
                        $this->em->persist($winnerWood);

                    } else if ($name == "stone") {
                        $stolenStone = (int)($looserRes->getAmount() * $stonePercent);
                        $looserRes->setAmount((int)($looserRes->getAmount() - $stolenStone));

                        $winnerStone = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($winner, 3);
                        $winnerStone->setAmount((int)($winnerStone->getAmount() + $stolenStone));
                        $this->em->persist($winnerStone);

                    } else if ($name == "gold") {
                        $stolenGold = (int)($looserRes->getAmount() * $goldPercent);
                        $looserRes->setAmount((int)($looserRes->getAmount() - $stolenGold));

                        $winnerGold = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($winner, 4);
                        $winnerGold->setAmount((int)($winnerGold->getAmount() + $stolenGold));
                        $this->em->persist($winnerGold);
                    }


                    $this->em->persist($looserRes);
                    $this->em->flush();
                }

                $batReport->setWinner($attacker);
                $batReport->setLooser($victim);
                $batReport->setStolenFood($stolenFood);
                $batReport->setStolenWood($stolenWood);
                $batReport->setStolenStone($stolenStone);
                $batReport->setStolenGold($stolenGold);

                $this->em->persist($batReport);
                $this->em->flush();

            }
        }

    }

}