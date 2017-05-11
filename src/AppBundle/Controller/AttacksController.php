<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Attack;
use AppBundle\Entity\User;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

/**
 * @property  Container container
 */
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

        $victimName = $this->getDoctrine()->getRepository(User::class)->find($id)->getFullName();

        $user = $this->getUser();

        $units = $this->getDoctrine()->getRepository(UserUnits::class)->getUserUnitsByStatus($user, "free");

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
        $attackStartService = $this->container->get('attack_start');

        //get request data
        $unitsInAttack = $request->get('units');
        $victimId = $request->get('victimId');

        if ($unitsInAttack === NULL){
            $this->redirectToRoute('battle_report');
        }

        $attacker = $this->getUser();
        $victim = $this->getDoctrine()->getRepository(User::class)->find($victimId);

        //calculate distance
        $distance = $attackStartService->calculateDistance($victim, $attacker);

        //create new attack
        $attackStartService->createNewAttack($victim, $attacker, $distance);


        $attackId = $this->getDoctrine()->getRepository(Attack::class)->getAttack($attacker, $victim, "progress")[0];

        //make units busy
        $attackStartService->makeUnitsBusy($unitsInAttack, $attackId);

        return $this->redirectToRoute('home_page') ;
    }
}
