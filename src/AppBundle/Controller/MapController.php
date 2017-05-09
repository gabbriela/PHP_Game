<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Map;
use AppBundle\Service\MapService;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\Container;

/**
 * @property  Container container
 */
class MapController extends Controller
{
    /**
     * @Route("/map", name="map")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mapAction()
    {
        $currentUser = $this->getUser();

        $map = $this->getDoctrine()->getRepository(Map::class)->findBy(array(), array('positionY' => 'ASC', 'positionX' => 'ASC'));

        //$mapService = $this->container->get('map_manager');
        //$map = $mapService->GetUsersOnMap();

        $size = count($map);

        $user = $this->getUser();

        return $this->render("Map/map.html.twig",
            ['mapAll' => $map, 'currentUser' => $currentUser, 'size'=>$size]);
    }
}
