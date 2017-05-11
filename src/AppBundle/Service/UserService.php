<?php
/**
 * Created by PhpStorm.
 * User: Gabi
 * Date: 10-May-17
 * Time: 20:03
 */

namespace AppBundle\Service;


use AppBundle\Entity\ProgressResourcesRenew;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserResource;

class UserService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function setInitialsBuildings($user)
    {
        $castle = $this->em->getRepository('AppBundle:Building')->getBuildingByName("Castle");
        $house1 = $this->em->getRepository('AppBundle:Building')->getBuildingByName("House");
        $house2 = $this->em->getRepository('AppBundle:Building')->getBuildingByName("House");
        $farm = $this->em->getRepository('AppBundle:Building')->getBuildingByName("Farm");

        $startBuildings =[$castle, $house1, $house2, $farm];

        foreach($startBuildings as $building){

            $userBuilding = new UserBuilding();
            $userBuilding->setUser($user);
            $userBuilding->setBuilding($building);
            $userBuilding->setBuildingLevel(1);

            $this->em->persist($userBuilding);
            $this->em->flush();

            if($building->getName() == 'Farm'){
                $now = new \DateTime('now');
                $resourceBuilding = new ProgressResourcesRenew();
                $resourceBuilding->setUserBuilding($userBuilding);
                $resourceBuilding->setLastUpdateOn($now);
                $resourceBuilding->setUser($user);

                $this->em->persist($resourceBuilding);
                $this->em->flush();
            }
        }
    }

    public function setInitialResources($user)
    {
        $initialResources = $this->em->getRepository('AppBundle:Resources')->getAllResources();

        foreach ($initialResources as $res){
            $userRes = new UserResource();

            $userRes->setUser($user);
            $userRes->addResource($res);
            $userRes->setAmount(10000);

            $this->em->persist($userRes);
            $this->em->flush();
        }
    }
}