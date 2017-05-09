<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attack;
use AppBundle\Entity\AttackUnits;
use AppBundle\Entity\BattleReport;
use AppBundle\Entity\UserResource;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BattlesController extends Controller
{
    /**
     * @Route("/report", name="battle_report")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function reportAction()
    {
        $user = $this->getUser();

        $userAttacks = $this->getDoctrine()->getRepository(Attack::class)->findBy(['attacker' => $user, 'status' => 'progress']);

        $now = new \DateTime('now');

        $em = $this->getDoctrine()->getManager();

        //Update attacks
        foreach ($userAttacks as $uattack){
            if ($now >= $uattack->getArriveOn()) {
                $uattack->setStatus('ready');
                $em->persist($uattack);

                $attacker = $uattack->getAttacker();
                $victim = $uattack->getVictim();

                $attackerLife = 0;
                $attackerDmg = 0;
                $victimLife = 0;
                $victimDmg = 0;

                $attackItself = $this->getDoctrine()->getRepository(Attack::class)->findOneBy([
                    'attacker' =>$attacker, 'victim' => $victim, 'status' => 'progress'
                ]);

                $attackerUnits = $this->getDoctrine()->getRepository(AttackUnits::class)->findBy([
                    'attack' => $attackItself,
                    'status'=>'progress']);

                $victimUnits = $this->getDoctrine()->getRepository(UserUnits::class)->findBy([
                    'status' => "free",
                    'user' => $victim]);

                 foreach ($attackerUnits as $au){
                     $attackerDmg += $au->getUserUnit()->getUnit()->getDamage();
                     $attackerLife += $au->getUserUnit()->getLifePoints();

                     $au->setStatus('ready');
                     $auUserUnit = $this->getDoctrine()->getRepository(UserUnits::class)->findOneBy(['id' => $au->getUserUnitId()]);
                     $rndAuLife = random_int(-20, $auUserUnit->getLifePoints());

                     $auUserUnit->setLifePoints($rndAuLife);
                     if($rndAuLife <= 0){
                         $auUserUnit->setStatus('dead');
                     } else {
                         $auUserUnit->setStatus('free');
                     }

                     $em = $this->getDoctrine()->getManager();
                     $em->persist($au);
                     $em->persist($auUserUnit);
                     $em->flush();
                 }

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

                     $em = $this->getDoctrine()->getManager();
                     $em->persist($vu);
                     $em->flush();
                 }

                $batReport = new BattleReport();
                $batReport->setAttack($uattack);


                 //battle

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
                $looserResources = $this->getDoctrine()->getRepository(UserResource::class)->findBy([
                    'user'=>$looser]);

                foreach ($looserResources as $looserRes) {
                    $name = $looserRes->getResources()->getName();

                    $em = $this->getDoctrine()->getManager();

                    if ($name == "food") {
                        $stolenFood = (int)($looserRes->getAmount() * $foodPercent);
                        $looserRes->setAmount((int)($looserRes->getAmount() - $stolenFood));

                        $winnerFood = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy([
                            'user'=>$winner, 'resourceId' => 1]);

                        $winnerFood->setAmount((int)($winnerFood->getAmount() + $stolenFood));
                        $em->persist($winnerFood);

                    } else if ($name == "wood") {
                        $stolenWood = (int)($looserRes->getAmount() * $woodPercent);
                        $looserRes->setAmount((int)($looserRes->getAmount() - $stolenWood));

                        $winnerWood = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy([
                            'user'=>$winner, 'resourceId' => 2]);
                        $winnerWood->setAmount((int)($winnerWood->getAmount() + $stolenWood));
                        $em->persist($winnerWood);

                    } else if ($name == "stone") {
                        $stolenStone = (int)($looserRes->getAmount() * $stonePercent);
                        $looserRes->setAmount((int)($looserRes->getAmount() - $stolenStone));

                        $winnerStone = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy([
                            'user'=>$winner, 'resourceId' => 3]);
                        $winnerStone->setAmount((int)($winnerStone->getAmount() + $stolenStone));
                        $em->persist($winnerStone);

                    } else if ($name == "gold") {
                        $stolenGold = (int)($looserRes->getAmount() * $goldPercent);
                        $looserRes->setAmount((int)($looserRes->getAmount() - $stolenGold));

                        $winnerGold = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy([
                            'user'=>$winner, 'resourceId' => 4]);
                        $winnerGold->setAmount((int)($winnerGold->getAmount() + $stolenGold));
                        $em->persist($winnerGold);
                    }


                    $em->persist($looserRes);
                    $em->flush();
                }

                $batReport->setWinner($attacker);
                $batReport->setLooser($victim);
                $batReport->setStolenFood($stolenFood);
                $batReport->setStolenWood($stolenWood);
                $batReport->setStolenStone($stolenStone);
                $batReport->setStolenGold($stolenGold);

                $em->persist($batReport);
                $em->flush();

            }
        }


        $userAttacksUpdated = $this->getDoctrine()->getRepository(Attack::class)->findBy(['attacker' => $user, 'status' => 'progress']);


        $userWinner = $this->getDoctrine()->getRepository(BattleReport::class)->findBy(['winner' => $user]);
        $userLooser = $this->getDoctrine()->getRepository(BattleReport::class)->findBy(['looser' => $user]);

        return $this->render('Attacks/attackInformation.html.twig',[
            'currentAttack' => $userAttacksUpdated,
            'userWinner' => $userWinner,
            'userLooser' => $userLooser]);
    }
}
