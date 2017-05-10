<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Building;
use AppBundle\Entity\ProgressBuilding;
use AppBundle\Entity\ProgressBuildingLevel;
use AppBundle\Entity\UserBuilding;
use AppBundle\Entity\UserResource;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;


/**
 * @property  Container container
 */
class BuildingsController extends Controller
{
    /**
     * @Route("/buildings", name="buildings")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function buildingsAction()
    {
        $buildings = $this->getDoctrine()->getRepository(Building::class)->getAllBuildings();
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
        $buildingService = $this->container->get('buildings_service');


        $user = $this->getUser();
        $userId = $user->getId();

        $isBuild = $buildingService->build($user, $id);

        if($isBuild)
        {
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

        $buildingService = $this->container->get('buildings_service');

        $user = $this->getUser();
        $userId = $user->getId();

        $isLvlUp = $buildingService->levelUp($user, $id);

        if(!$isLvlUp) {
            $buildings = $this->getDoctrine()
                ->getRepository(Building::class)->findAll();

            $error = "Not enough resources.";

            return $this->render("Buildings/buildings.html.twig",
                ['buildings' => $buildings, 'error' => $error]);
        }

        return $this->redirectToRoute('home_page');
    }
}
