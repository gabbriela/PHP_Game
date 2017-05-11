<?php
/**
 * Created by PhpStorm.
 * User: Gabi
 * Date: 10-May-17
 * Time: 14:04
 */

namespace AppBundle\Service;


use AppBundle\Entity\ProgressBuilding;
use AppBundle\Entity\ProgressBuildingLevel;

class BuildingService
{
    private $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function build($user, $id)
    {
        //Building cost
        $building = $this->em->getRepository('AppBundle:Building')->getBuildingById($id);
        $woodCost = $building->getWoodCost();
        $stoneCost = $building->getStoneCost();
        $goldCost = $building->getGoldCost();

        //User res
        $wood = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 2);     //findOneBy(['userId' => $userId, 'resourceId'=> 2]);
        $stone = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 3);    //findOneBy(['userId' => $userId, 'resourceId'=> 3]);
        $gold = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 4);     //findOneBy(['userId' => $userId, 'resourceId'=> 4]);

        $userWood = $wood->getAmount();
        $userStone = $stone->getAmount();
        $userGold = $gold->getAmount();

        //Check if user has enough amount
        if ($woodCost <= $userWood && $stoneCost <= $userStone && $goldCost <= $userGold)
        {
            $now = new \DateTime('now');

            //Add building to user
            $progressBuilding = new ProgressBuilding();
            $progressBuilding->setUser($user);
            $progressBuilding->setBuilding($building);
            $progressBuilding->setReadyOn($now->add(new \DateInterval('PT' . $building->getBuildTime() . 'S')));

            $this->em->persist($progressBuilding);

            //subtract resources amount
            $userWood -= $woodCost;
            $userStone -= $stoneCost;
            $userGold -= $goldCost;

            $wood->setAmount($userWood);
            $stone->setAmount($userStone);
            $gold->setAmount($userGold);

            $this->em->persist($wood);
            $this->em->persist($stone);
            $this->em->persist($gold);
            $this->em->flush();

           return true;
        }
        return false;
    }

    public function levelUp($user, $id)
    {
        $building = $this->em->getRepository('AppBundle:UserBuilding')->getBuildingById($id);;
        $buildingLevel = $building->getBuildingLevel();

        //User res
        $wood = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 2);
        $stone = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 3);
        $gold = $this->em->getRepository('AppBundle:UserResource')->getUserResourcesById($user, 4);
        $userWood = $wood->getAmount();
        $userStone = $stone->getAmount();
        $userGold = $gold->getAmount();

        //Price
        $lvlUpWood = 200 * ($buildingLevel / 2);
        $lvlUpStone = 150 * ($buildingLevel / 2);
        $lvlUpGold = 100 * ($buildingLevel * 1.15);


        if ($userGold >= $lvlUpGold &&
            $userStone >= $lvlUpStone &&
            $userWood >= $lvlUpWood) {

            $userGold -= $lvlUpGold;
            $userWood -= $lvlUpWood;
            $userStone -= $lvlUpStone;

            $gold->setAmount($userGold);
            $stone->setAmount($userStone);
            $wood->setAmount($userWood);

            $now = new \DateTime('now');
            $lvlUpTime = $buildingLevel * 500;

            $progressLevel = new ProgressBuildingLevel();
            $progressLevel->setReadyOn($now->add(new \DateInterval('PT' . $lvlUpTime . 'S')));

            $progressLevel->setUserBuilding($building);
            $progressLevel->setUser($user);

            $this->em->persist($progressLevel);
            $this->em->flush();

            return true;
        }
        return false;
    }
}