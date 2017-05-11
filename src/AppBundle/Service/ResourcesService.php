<?php
/**
 * Created by PhpStorm.
 * User: Gabi
 * Date: 10-May-17
 * Time: 17:14
 */

namespace AppBundle\Service;


class ResourcesService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function getBuildingsToExplore($user)
    {
        $buildingsToExplore = [];

        $resourcesBuildings = $this->em->getRepository('AppBundle:UserBuilding')->getUserBuildingsByBuildingId($user, 3);

        foreach ($resourcesBuildings as $explore){
            $buildingsToExplore[] = $explore;
        }

        $resourcesBuildings = $this->em->getRepository('AppBundle:UserBuilding')->getUserBuildingsByBuildingId($user, 9);

        foreach ($resourcesBuildings as $explore){
            $buildingsToExplore[] = $explore;
        }

        $resourcesBuildings = $this->em->getRepository('AppBundle:UserBuilding')->getUserBuildingsByBuildingId($user, 10);

        foreach ($resourcesBuildings as $explore){
            $buildingsToExplore[] = $explore;
        }

        $resourcesBuildings = $this->em->getRepository('AppBundle:UserBuilding')->getUserBuildingsByBuildingId($user, 11);

        foreach ($resourcesBuildings as $explore){
            $buildingsToExplore[] = $explore;
        }

        return $buildingsToExplore;
    }

    public function updateResources($user)
    {
        $resourceRenewBuildings = $this->em->getRepository('AppBundle:ProgressResourcesRenew')->getResRenewByUser($user);

        $now = new \DateTime('now');

        foreach ($resourceRenewBuildings as $buildingToUpdateRes) {

            $lastUpdate = $buildingToUpdateRes->getLastUpdateOn();
            $dateDiffSeconds = $now->getTimestamp() - $lastUpdate->getTimestamp();

            $resAmountToAdd = (int)($dateDiffSeconds / $buildingToUpdateRes->getTime()) * $buildingToUpdateRes->getResourceAmount();

            if ($dateDiffSeconds < 200){
                $resAmountToAdd = 0;
            } else {$buildingToUpdateRes->setLastUpdateOn($now);}

            $userBuildingId = $buildingToUpdateRes->getUserBuildingId();

            $buildToAddRes = $this->em->getRepository('AppBundle:UserBuilding')->getBuildingById($userBuildingId);
            //find($buildingToUpdateRes->getUserBuildingId());

            if (($buildToAddRes->getResourceAmount() + $resAmountToAdd) <= $buildToAddRes->getResourceMax())
            {
                $buildToAddRes->setResourceAmount($buildToAddRes->getResourceAmount() + $resAmountToAdd);
            } else {
                $buildToAddRes->setResourceAmount($buildToAddRes->getResourceMax());
            }

            $this->em->persist($buildToAddRes);
            $this->em->persist($buildingToUpdateRes);
            $this->em->flush();

        }
    }

    public function getResources($user, $id)
    {
        //id = 3 -> food ; id = 9 -> wood ; id = 10 -> stone ; id = 11 -> gold
        $userBuilding = $this->em->getRepository('AppBundle:UserBuilding')->getBuildingById($id);

        $resourceAmount = $userBuilding->getResourceAmount();

        //if building is id=3 -> its Farm ->resource: food
        if($userBuilding->getBuilding()->getId() == 3){
            $userFood = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 1);
            $userFood->setAmount($userFood->getAmount() + $resourceAmount);

            $this->em->persist($userFood);
            $this->em->flush();
        } else if($userBuilding->getBuilding()->getId() == 9){
            $userWood = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 2);
            $userWood->setAmount($userWood->getAmount() + $resourceAmount);

            $this->em->persist($userWood);
            $this->em->flush();

        } else if($userBuilding->getBuilding()->getId() == 10){
            $userStone = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 3);
            $userStone->setAmount($userStone->getAmount() + $resourceAmount);

            $this->em->persist($userStone);
            $this->em->flush();
        } else if($userBuilding->getBuilding()->getId() == 11){
            $userGold = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 4);
            $userGold->setAmount($userGold->getAmount() + $resourceAmount);

            $this->em->persist($userGold);
            $this->em->flush();
        }

        $userBuilding->setResourceAmount(0);

        $this->em->persist($userBuilding);
        $this->em->flush();

    }
}