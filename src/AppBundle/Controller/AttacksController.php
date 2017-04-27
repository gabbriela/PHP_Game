<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attack;
use AppBundle\Entity\AttackUnits;
use AppBundle\Entity\Unit;
use AppBundle\Entity\User;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AttacksController extends Controller
{
    /**
     * @Route("/attack_prepare/{id}", name="attack_prepare")
     * @param  $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function attackPrepareAction($id)
    {
        $victimId = $id;

        $attacker = $this->getUser();
        $victim = $this->getDoctrine()->getRepository(User::class)->find($victimId);
        $distanceVictim = $victim->getMap()->getPositionX() + $victim->getMap()->getPositionY();
        $distanceAttacker = $attacker->getMap()->getPositionX() + $attacker->getMap()->getPositionY();

        $distance = abs($distanceAttacker - $distanceVictim);

        $now = new \DateTime('now');

        $arriveAfter = ($now->add(new \DateInterval('PT' . $distance . 'S')))->format('H:i:s');

        //var_dump($id); exit;
        //victimID
        $victimName = $this->getDoctrine()->getRepository(User::class)->find($id)->getFullName();

        $user = $this->getUser();

        $units = $this->getDoctrine()->getRepository(UserUnits::class)->findBy([
            'user' => $user,
            'status' => 'free'],
            array('unitId' => 'ASC'));

        return $this->render('Attacks/attackPrepare.html.twig',[
            'victim' => $victimName,
            'units' => $units,
            'victimId' => $id,
            'arriveAfter' => $arriveAfter]);
    }




    /**
     * @Route("/attack/start", name="attack")
     * @param  Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function attackStartAction(Request $request)
    {
        $unitsInAttack = $request->get('units');
        $victimId = $request->get('victimId');

        $attacker = $this->getUser();
        $victim = $this->getDoctrine()->getRepository(User::class)->find($victimId);
        $distanceVictim = $victim->getMap()->getPositionX() + $victim->getMap()->getPositionY();
        $distanceAttacker = $attacker->getMap()->getPositionX() + $attacker->getMap()->getPositionY();

        $distance = abs($distanceAttacker - $distanceVictim) * 100;

        $attackerUnitsLife = 0;
        $attackerUnitsDmg = 0;


        $attack = new Attack();
        $attack->setStatus("progress");
        $attack->setAttacker($attacker);
        $attack->setVictim($victim);

        $now = new \DateTime('now');

        $attack->setArriveOn($now->add(new \DateInterval('PT' . $distance . 'S')));
        $em = $this->getDoctrine()->getManager();
        $em->persist($attack);
        $em->flush();

        //var_dump($victim); exit;

        $attackId = $this->getDoctrine()->getRepository(Attack::class)->findOneBy(['attacker' => $attacker,
            'victim' => $victim,
            'status' =>'progress']);

        //var_dump($attackId); exit;

        //make units busy
        foreach ($unitsInAttack as $busyUnitId)
        {
            $unit = $this->getDoctrine()->getRepository(UserUnits::class)->find($busyUnitId);
            $unit->setStatus('busy');

            $attackerUnitsLife += $unit->getLifePoints();
            $checkUnit = $unit->getUnitId();
            $attackerUnitsDmg += $this->getDoctrine()->getRepository(Unit::class)->find($checkUnit)->getDamage();

            $userUnit = $this->getDoctrine()->getRepository(UserUnits::class)->find($busyUnitId);

            $attackUnit = new AttackUnits();
            $attackUnit->setStatus('progress');
            $attackUnit->setAttack($attackId);
            $attackUnit->setUserUnit($userUnit);


            $em = $this->getDoctrine()->getManager();
            $em->persist($unit);
            $em->persist($attackUnit);
            $em->flush();
        }


        return $this->redirectToRoute('home_page') ;
    }
}
