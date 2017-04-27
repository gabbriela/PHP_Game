<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Map;
use AppBundle\Entity\UserUnits;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        $size = count($map);

        $user = $this->getUser();

        return $this->render("information/map.html.twig",
            ['mapAll' => $map, 'currentUser' => $currentUser, 'size'=>$size]);
    }
}
