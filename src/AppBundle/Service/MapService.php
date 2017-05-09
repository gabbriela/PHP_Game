<?php

namespace AppBundle\Service;

use AppBundle\Repository\MapRepository;



class MapService
{
    protected $users_on_map;

    /**
     * MapService constructor.
     *
     * @param MapRepository $repo
     */
    public function __construct(MapRepository $repo)
    {
        $this->users_on_map =  $repo->GetUsersOnMap();
    }

    public function GetUsersOnMap()
    {
        return $this->users_on_map;
    }
}