<?php

namespace AppBundle\Controller;

use AppBundle\Entity\ProgressBuilding;
use AppBundle\Entity\Building;
use AppBundle\Entity\ProgressBuildingLevel;
use AppBundle\Entity\ProgressResourcesRenew;
use AppBundle\Entity\ProgressUnits;
use AppBundle\Entity\Unit;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProgressController extends Controller
{
    /**
     * @Route("/progress", name="in_progress")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $user = $this->getUser();

        $now = new \DateTime('now');

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

        //Buildings in progress
        $buildingsInProgress = $this->getDoctrine()->getRepository(ProgressBuilding::class)->findBy(['user' => $user, 'status' =>'progress']);
        $buildingsReadyAfter = [];
        foreach ($buildingsInProgress as $build) {
            $dateDiff = date_diff($build->getReadyOn(), $now );

            $buildingsReadyAfter[] = ['building' => $build->getBuilding()->getName(), 'readyAfter' => $dateDiff->format('%H:%I:%S')];
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


        //Building level in progress
        $levelInProgress = $this->getDoctrine()->getRepository(ProgressBuildingLevel::class)->findBy(['user' => $user, 'status' =>'progress']);
        $buildingsLevelAfter = [];
        foreach ($levelInProgress as $levelBuild) {
            $dateDiff = date_diff($levelBuild->getReadyOn(), $now );

            $buildingsLevelAfter[] = ['buildingName' => $levelBuild->getUserBuilding()->getBuilding()->getName(), 'readyAfter' => $dateDiff->format('%H:%I:%S')];
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

        //Units in progress
        $unitsInProgress = $this->getDoctrine()->getRepository(ProgressUnits::class)->findBy(['user' => $user, 'status' =>'progress']);
        $unitsAfter = [];
        foreach ($unitsInProgress as $unit) {
            $dateDiff = date_diff($unit->getReadyOn(), $now );

            $unitsAfter[] = ['name' => $unit->getUnit()->getName(), 'readyAfter' => $dateDiff->format('%H:%I:%S')];
        }

        return $this->render("Buildings/progress.html.twig", ['progressBuildings' => $buildingsReadyAfter,
                                                                'levelBuildings' => $buildingsLevelAfter ,
                                                                'units' => $unitsAfter]);
    }
}
