<?php

namespace AppBundle\Controller;

use AppBundle\Entity\UserResource;
use AppBundle\Entity\Attack;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;

/**
 * @property  Container container
 */
class ResourcesController extends Controller
{
    /**
     * @Route("/", name="resources")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resourcesAction()
    {
        $user = $this->getUser();
        $resources = $this->getDoctrine()->getRepository(UserResource::class)->getUserResources($user);

        //$attacksToMe = $this->getDoctrine()->getRepository(Attack::class)->getVictimAttacks($user, "progress");
        //$attacksToMe = $this->getDoctrine()->getRepository(Attack::class)->findBy(['victim' => $user, 'status' => 'progress']);

        $attacksToMe = $this->getDoctrine()->getRepository(Attack::class)->findBy(['victim' => $user, 'status' => 'progress']);

foreach ($attacksToMe as $att)
{

}
        return $this->render("Resources/resources.html.twig",
            ['resources' => $resources, 'attacks' => $attacksToMe]);
    }

    /**
     * @Route("/explore", name="resource_explore")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function exploreAction()
    {
        $user = $this->getUser();

        $resourcesService = $this->container->get('resources_service');

        //Update resources
        $resourcesService->updateResources($user);

        $buildingsToExplore = $resourcesService->getBuildingsToExplore($user);

        return $this->render("Resources/resourceExplore.html.twig", ['buildingsToExplore' => $buildingsToExplore]);
    }

    /**
     * @Route("/explore/{id}", name="resource_get")
     * @param  integer $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getResourcesAction($id)
    {
        $user = $this->getUser();

        $resourcesService = $this->container->get('resources_service');

        $resourcesService->getResources($user, $id);


        return $this->redirectToRoute('resource_explore');
    }
}
