<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Building;
use AppBundle\Entity\ProgressBuilding;
use AppBundle\Entity\ProgressResourcesRenew;
use AppBundle\Entity\Resources;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ResourcesController extends Controller
{
    /**
     * @Route("/", name="resources")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resourcesAction()
    {
        $user = $this->getUser();
        $resources = $this->getDoctrine()->getRepository(UserResource::class)->findBy(['user' => $user]);

        return $this->render("Resources/resources.html.twig",
            ['resources' => $resources]);
    }

    /**
     * @Route("/explore", name="resource_explore")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exploreAction()
    {
        $user = $this->getUser();
        $now = new \DateTime('now');


        //Update resources
        $resourceRenewBuildings = $this->getDoctrine()->getRepository(ProgressResourcesRenew::class)->findBy(['user'=> $user]);

        foreach ($resourceRenewBuildings as $buildingToUpdateRes) {

            $lastUpdate = $buildingToUpdateRes->getLastUpdateOn();
            $dateDiffSeconds = $now->getTimestamp() - $lastUpdate->getTimestamp();

            $resAmountToAdd = (int)($dateDiffSeconds / $buildingToUpdateRes->getTime()) * $buildingToUpdateRes->getResourceAmount();

            if ($dateDiffSeconds < 200){
                $resAmountToAdd = 0;
            } else {$buildingToUpdateRes->setLastUpdateOn($now);}


            $buildToAddRes = $this->getDoctrine()->getRepository(UserBuilding::class)->find($buildingToUpdateRes->getUserBuildingId());

            if (($buildToAddRes->getResourceAmount() + $resAmountToAdd) <= $buildToAddRes->getResourceMax())
            {
                $buildToAddRes->setResourceAmount($buildToAddRes->getResourceAmount() + $resAmountToAdd);
            } else {
                $buildToAddRes->setResourceAmount($buildToAddRes->getResourceMax());
            }


            $em = $this->getDoctrine()->getManager();
            $em->persist($buildToAddRes);
            $em->persist($buildingToUpdateRes);
            $em->flush();

        }




        $buildingsToExplore = [];

        $resourcesBuildings = $this->getDoctrine()->getRepository(UserBuilding::class)->findBy(['buildingId' => 3, 'user'=> $user]);

        foreach ($resourcesBuildings as $explore){
            $buildingsToExplore[] = $explore;
        }

        $resourcesBuildings = $this->getDoctrine()->getRepository(UserBuilding::class)->findBy(['buildingId' => 9, 'user'=> $user]);

        foreach ($resourcesBuildings as $explore){
            $buildingsToExplore[] = $explore;
        }

        $resourcesBuildings = $this->getDoctrine()->getRepository(UserBuilding::class)->findBy(['buildingId' => 10, 'user'=> $user]);

        foreach ($resourcesBuildings as $explore){
            $buildingsToExplore[] = $explore;
        }

        $resourcesBuildings = $this->getDoctrine()->getRepository(UserBuilding::class)->findBy(['buildingId' => 11, 'user'=> $user]);

        foreach ($resourcesBuildings as $explore){
            $buildingsToExplore[] = $explore;
        }


        if ($resourcesBuildings !== null)
        {
            return $this->render("Resources/resourceExplore.html.twig", ['buildingsToExplore' => $buildingsToExplore]);
        }

        return $this->render('user/profile.html.twig');
    }

    /**
     * @Route("/explore/{id}", name="resource_get")
     * @param  integer $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getResourcesAction($id)
    {
        $user = $this->getUser();

        //id = 3 -> food ; id = 9 -> wood ; id = 10 -> stone ; id = 11 -> gold
        $userBuilding = $this->getDoctrine()->getRepository(UserBuilding::class)->findOneBy(['id' => $id]);

        $resourceAmount = $userBuilding->getResourceAmount();

        //if building is id=3 -> its Farm ->resource: food
        if($userBuilding->getBuilding()->getId() == 3){
            $userFood = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['resourceId' => 1, 'user' => $user]);
            $userFood->setAmount($userFood->getAmount() + $resourceAmount);

            $em = $this->getDoctrine()->getManager();
            $em->persist($userFood);
            $em->flush();
        } else if($userBuilding->getBuilding()->getId() == 9){
            $userWood = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['resourceId' => 2, 'user' => $user]);
            $userWood->setAmount($userWood->getAmount() + $resourceAmount);

            $em = $this->getDoctrine()->getManager();
            $em->persist($userWood);
            $em->flush();
        } else if($userBuilding->getBuilding()->getId() == 10){
            $userStone = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['resourceId' => 3, 'user' => $user]);
            $userStone->setAmount($userStone->getAmount() + $resourceAmount);

            $em = $this->getDoctrine()->getManager();
            $em->persist($userStone);
            $em->flush();
        } else if($userBuilding->getBuilding()->getId() == 11){
            $userGold = $this->getDoctrine()->getRepository(UserResource::class)->findOneBy(['resourceId' => 4, 'user' => $user]);
            $userGold->setAmount($userGold->getAmount() + $resourceAmount);

            $em = $this->getDoctrine()->getManager();
            $em->persist($userGold);
            $em->flush();
        }

        $userBuilding->setResourceAmount(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($userBuilding);
        $em->flush();

        return $this->redirectToRoute('resource_explore');
    }
}
