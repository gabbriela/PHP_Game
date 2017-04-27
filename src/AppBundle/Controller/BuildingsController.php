<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Building;
use AppBundle\Entity\ProgressBuilding;
use AppBundle\Entity\ProgressBuildingLevel;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BuildingsController extends Controller
{
    /**
     * @Route("/buildings", name="buildings")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function buildingsAction()
    {
        $buildings = $this->getDoctrine()
            ->getRepository(Building::class)->findAll();
    $error = "";
        return $this->render("Buildings/buildings.html.twig",
            ['buildings' => $buildings, 'error' => $error]);
    }

    /**
     * @Route("/buildings/{id}", name="building_create")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction($id)
    {
        $building = $this->getDoctrine()->getRepository(Building::class)->find($id);

        $user = $this->getUser();
        $userId = $user->getId();

        //Building cost
        $woodCost = $building->getWoodCost();
        $stoneCost = $building->getStoneCost();
        $goldCost = $building->getGoldCost();

        //User res
        $wood = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['userId' => $userId, 'resourceId'=> 2]);
        $stone = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['userId' => $userId, 'resourceId'=> 3]);
        $gold = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['userId' => $userId, 'resourceId'=> 4]);
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($progressBuilding);
            $em->flush();

            //subtract resources amount
            $userWood -= $woodCost;
            $userStone -= $stoneCost;
            $userGold -= $goldCost;

            $wood->setAmount($userWood);
            $stone->setAmount($userStone);
            $gold->setAmount($userGold);

            $em = $this->getDoctrine()->getManager();
            $em->persist($wood);
            $em->persist($stone);
            $em->persist($gold);
            $em->flush();

            return $this->redirectToRoute('in_progress');
        } else {
            $error = "Not enough resources.";
            $buildings = $this->getDoctrine()
                ->getRepository(Building::class)->findAll();

            return $this->render("Buildings/buildings.html.twig",
                ['buildings' => $buildings, 'error' => $error]);
        }

    }

    /**
     * @Route("building_levelup/{id}", name="building_levelup")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function levelUpAction($id){

        $user = $this->getUser();
        $userId = $user->getId();

        $building = $this->getDoctrine()->getRepository(UserBuilding::class)->find($id);
        $buildingLevel = $building->getBuildingLevel();

        //User res
        $wood = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['userId' => $userId, 'resourceId'=> 2]);
        $stone = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['userId' => $userId, 'resourceId'=> 3]);
        $gold = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['userId' => $userId, 'resourceId'=> 4]);
        $userWood = $wood->getAmount();
        $userStone = $stone->getAmount();
        $userGold = $gold->getAmount();

        //Price
        $lvlUpWood = 200 * ($buildingLevel / 2);
        $lvlUpStone = 150 * ($buildingLevel / 2);
        $lvlUpGold = 100 * ($buildingLevel * 1.15);


        if ($userGold >= $lvlUpGold &&
            $userStone >= $lvlUpStone &&
            $userWood >= $lvlUpWood){

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

            $em = $this->getDoctrine()->getManager();
            $em->persist($progressLevel);
            $em->flush();
        } else {
            $buildings = $this->getDoctrine()
                ->getRepository(Building::class)->findAll();

            $error = "Not enough resources.";

            return $this->render("Buildings/buildings.html.twig",
                ['buildings' => $buildings, 'error' => $error]);
        }

        return $this->redirectToRoute('home_page');
    }
}
