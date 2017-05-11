<?php
/**
 * Created by PhpStorm.
 * User: Gabi
 * Date: 10-May-17
 * Time: 15:36
 */

namespace AppBundle\Service;


use AppBundle\Entity\ProgressResourcesRenew;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserUnits;

class ProgressService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function updateBuildings($user)
    {
        //Update buildings
        $progressBuildings = $this->em->getRepository('AppBundle:ProgressBuilding')->getBuildingsByStatus($user, "progress");

        $now = new \DateTime('now');

        foreach ($progressBuildings as $progressBuilding) {

            if( $now >= $progressBuilding->getReadyOn()){

                $progressBuilding->setStatus("ready");

                $buildingId = $progressBuilding->getBuildingId();

                $building = $this->em->getRepository('AppBundle:Building')->getBuildingById($buildingId);

                //Add building to user
                $userBuilding = new UserBuilding();
                $userBuilding->setUser($user);
                $userBuilding->setBuilding($building);
                $userBuilding->setBuildingLevel(1);
                $userBuilding->setResourceAmount($building->getInitialResource());
                $userBuilding->setResourceMax(1500);

                $this->em->persist($userBuilding);
                $this->em->persist($progressBuilding);

                if($progressBuilding->getBuildingId() == 3
                    || $progressBuilding->getBuildingId() == 9
                    || $progressBuilding->getBuildingId() == 10
                    || $progressBuilding->getBuildingId() == 11){

                    $resourceBuilding = new ProgressResourcesRenew();
                    $resourceBuilding->setUserBuilding($userBuilding);
                    $resourceBuilding->setLastUpdateOn($now);
                    $resourceBuilding->setUser($user);

                    $this->em->persist($resourceBuilding);
                }

                $this->em->flush();

            }
        }
    }

    public function updateBuildingsLevel($user)
    {
        $progressLevel = $this->em->getRepository('AppBundle:ProgressBuildingLevel')->getBuildingsLevelByStatus($user, "progress");

        $now = new \DateTime('now');

        foreach ($progressLevel as $levelCheck)
        {
            if( $now >= $levelCheck->getReadyOn()) {
                $levelCheck->setStatus("ready");

                $buildingId = $levelCheck->getUserBuildingId();

                $userBuilding = $this->em->getRepository('AppBundle:UserBuilding')->getBuildingById($buildingId);

                $currentLevel = $userBuilding->getBuildingLevel();
                $userBuilding->setBuildingLevel($currentLevel + 1);
                $userBuilding->setResourceMax(($currentLevel + 1) * 1200);

                $this->em->persist($userBuilding);
                $this->em->persist($levelCheck);
                $this->em->flush();
            }
        }
    }

    public function updateUnits($user)
    {
        $progressUnits = $this->em->getRepository('AppBundle:ProgressUnits')->getUnitsByStatus($user, "progress");

        $now = new \DateTime('now');

        foreach ($progressUnits as $progressUnit) {

            if($now >= $progressUnit->getReadyOn()){
                $progressUnit->setStatus("ready");

                $unitId = $progressUnit->getUnitId();

                $readyUnit = $this->em->getRepository('AppBundle:Unit')->getUnitById($unitId);

                $userUnit = new UserUnits();
                $userUnit->setUser($user);
                $userUnit->setUnit($readyUnit);
                $userUnit->setLifePoints($readyUnit->getLifePoints());

                $this->em->persist($userUnit);
                $this->em->persist($progressUnit);
                $this->em->flush();
            }
        }
    }

}
