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
use Symfony\Component\DependencyInjection\Container;

/**
 * @property  Container container
 */
class ProgressController extends Controller
{
    /**
     * @Route("/progress", name="in_progress")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAction()
    {
        $user = $this->getUser();

        $progressService = $this->container->get('progress_service');

        //update buildings
        $progressService->updateBuildings($user);

        $now = new \DateTime('now');

        //Buildings in progress
        $buildingsInProgress = $this->getDoctrine()->getRepository(ProgressBuilding::class)->findBy(['user' => $user, 'status' =>'progress']);
        $buildingsReadyAfter = [];
        foreach ($buildingsInProgress as $build) {
            $dateDiff = date_diff($build->getReadyOn(), $now );

            $buildingsReadyAfter[] = ['building' => $build->getBuilding()->getName(), 'readyAfter' => $dateDiff->format('%H:%I:%S')];
        }


        //Update buildings level
        $progressService->updateBuildingsLevel($user);


        //Building level in progress
        $levelInProgress = $this->getDoctrine()->getRepository(ProgressBuildingLevel::class)->findBy(['user' => $user, 'status' =>'progress']);
        $buildingsLevelAfter = [];
        foreach ($levelInProgress as $levelBuild) {
            $dateDiff = date_diff($levelBuild->getReadyOn(), $now );

            $buildingsLevelAfter[] = ['buildingName' => $levelBuild->getUserBuilding()->getBuilding()->getName(), 'readyAfter' => $dateDiff->format('%H:%I:%S')];
        }

        //Update units
        $progressService->updateUnits($user);

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
