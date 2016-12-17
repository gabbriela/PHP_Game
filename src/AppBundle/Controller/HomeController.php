<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Building;
use AppBundle\Entity\ProgressBuilding;
use AppBundle\Entity\ProgressBuildingLevel;
use AppBundle\Entity\ProgressResourcesRenew;
use AppBundle\Entity\ProgressUnits;
use AppBundle\Entity\Unit;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserResource;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Validator\Constraints\DateTime;

class HomeController extends Controller
{


    /**
     * @Route("/home", name="home_page")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function homeAction()
    {
        $user = $this->getUser();

        //Update buildings
        $progressBuildings = $this->getDoctrine()->getRepository(ProgressBuilding::class)->findBy(['user' => $user, 'status' => "progress"]);

        foreach ($progressBuildings as $progressBuilding) {

            $now = new \DateTime('now');

            if( $now >= $progressBuilding->getReadyOn()){

                $progressBuilding->setStatus("ready");

                $building = $this->getDoctrine()->getRepository(Building::class)->find($progressBuilding->getBuildingId());

                //Add building to user
                $userBuilding = new UserBuilding();
                $userBuilding->setUser($user);
                $userBuilding->setBuilding($building);
                $userBuilding->setBuildingLevel(1);
                $userBuilding->setResourceAmount($building->getInitialResource());
                $userBuilding->setResourceMax(1500);

                $em = $this->getDoctrine()->getManager();
                $em->persist($userBuilding);
                $em->persist($progressBuilding);

                if($progressBuilding->getBuildingId() == 3
                    || $progressBuilding->getBuildingId() == 9
                    || $progressBuilding->getBuildingId() == 10
                    || $progressBuilding->getBuildingId() == 11){

                    $resourceBuilding = new ProgressResourcesRenew();
                    $resourceBuilding->setUserBuilding($userBuilding);
                    $resourceBuilding->setLastUpdateOn($now);
                    $resourceBuilding->setUser($user);

                    $em->persist($resourceBuilding);
                }

                $em->flush();

            }
        }

        //Update units
        $progressUnits = $this->getDoctrine()->getRepository(ProgressUnits::class)->findBy(['user' => $user, 'status' => "progress"]);

        foreach ($progressUnits as $progressUnit) {
            $now = new \DateTime('now');

            if($now >= $progressUnit->getReadyOn()){
                $progressUnit->setStatus("ready");


                $readyUnit = $this->getDoctrine()->getRepository(Unit::class)->find($progressUnit->getUnitId());

                $userUnit = new UserUnits();
                $userUnit->setUser($user);
                $userUnit->setUnit($readyUnit);
                $userUnit->setLifePoints($readyUnit->getLifePoints());

                $em = $this->getDoctrine()->getManager();
                $em->persist($userUnit);
                $em->persist($progressUnit);
                $em->flush();
            }
        }


        //Update buildings level

        $progressLevel = $this->getDoctrine()->getRepository(ProgressBuildingLevel::class)->findBy(['user' => $user, 'status' => "progress"]);

        foreach ($progressLevel as $levelCheck)
        {
            $now = new \DateTime('now');

            if( $now >= $levelCheck->getReadyOn()) {
                $levelCheck->setStatus("ready");

                $userBuilding = $this->getDoctrine()->getRepository(UserBuilding::class)->find($levelCheck->getUserBuildingId());
                $currentLevel = $userBuilding->getBuildingLevel();
                $userBuilding->setBuildingLevel($currentLevel + 1);
                $userBuilding->setResourceMax(($currentLevel + 1) * 1200);

                $em = $this->getDoctrine()->getManager();
                $em->persist($userBuilding);
                $em->persist($levelCheck);
                $em->flush();
            }
        }



        $unitsFree = $this->getDoctrine()->getRepository(UserUnits::class)->findBy([
            'user' => $user,
            'status'=> 'free'],
            array('unitId' => 'ASC'));

        $unitsBusy = $this->getDoctrine()->getRepository(UserUnits::class)->findBy([
            'user' => $user,
            'status'=> 'busy'],
            array('unitId' => 'ASC'));

        $buildings = $this->getDoctrine()->getRepository(UserBuilding::class)->findBy(['user' => $user], array('buildingId' =>'ASC'));

        return $this->render("default/home.html.twig", [
            'user'=>$user,
            'buildings' => $buildings,
            'unitsFree' => $unitsFree,
            'unitsBusy' => $unitsBusy]);

    }
}
