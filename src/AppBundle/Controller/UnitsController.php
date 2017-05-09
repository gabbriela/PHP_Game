<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProgressUnits;
use AppBundle\Entity\Unit;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserResource;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\Constraints\DateTime;

class UnitsController extends Controller
{
    const FOOD_ID = 1;

    /**
     * @Route("/units", name="list_units")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listUnitsAction()
    {
        $error = '';

        $units = $this->getDoctrine()->getRepository(Unit::class)->findAll();

        return $this->render('Units/hireUnits.html.twig', ['units' => $units, 'error' => $error]);
    }

    /**
     * @Route("/units/{id}", name="hire_units")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function hireAction($id)
    {
        $error = '';

        $unit = $this->getDoctrine()->getRepository(Unit::class)->find($id);

        $initialFood = $unit->getInitialFood();
        $buildingId = $unit->getBuilding()->getId();
        $buildingLevel = $unit->getBuildingLevel();


        $user = $this->getUser();

        $building = $this->getDoctrine()->getRepository(UserBuilding::class)->findOneBy(['user' => $user,
                                                                                       'buildingId' => $buildingId,
                                                                                       'buildingLevel' => $buildingLevel]);

        $userFood = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['user' => $user, 'resourceId' => self::FOOD_ID]);

        $foodAmount = $userFood->getAmount();

        if($building !== null  && $foodAmount >= $initialFood){

            $now = new \DateTime('now');

            $userFood->setAmount($foodAmount - $initialFood);

            $progressUnit = new ProgressUnits();
            $progressUnit->setUser($user);
            $progressUnit->setUnit($unit);
            $progressUnit->setReadyOn($now->add(new \DateInterval('PT' . $unit->getBuilldTime() . 'S')));

            $em = $this->getDoctrine()->getManager();
            $em->persist($userFood);
            $em->persist($progressUnit);
            $em->flush();

        } else {
            if($building === null) {$error = "You don't have the required building."; }
            else {$error = "Not enough resources."; }
        }

        $units = $this->getDoctrine()->getRepository(Unit::class)->findAll();

        return $this->render('Units/hireUnits.html.twig', ['units' => $units, 'error' => $error]);
    }
}
