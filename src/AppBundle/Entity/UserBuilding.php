<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserBuilding
 *
 * @ORM\Table(name="user_building")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserBuildingRepository")
 */
class UserBuilding
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;


    /**
     * @var int
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userBuildings")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;





    /**
     * @var int
     * @ORM\Column(name="buildingId", type="integer")
     */
    private $buildingId;

    /**
     * @var Building
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Building", inversedBy="userBuildings")
     * @ORM\JoinColumn(name="buildingId", referencedColumnName="id")
     */
    private $building;



    /**
     * @var ProgressBuildingLevel
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ProgressBuildingLevel", mappedBy="userBuilding")
     */
    private $progressLevel;


    /**
     * @var ProgressResourcesRenew
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\ProgressResourcesRenew", mappedBy="userBuilding")
     */
    private $resourcesRenew;



    /**
     * @var int
     *
     * @ORM\Column(name="buildingLevel", type="integer")
     */
    private $buildingLevel;


    /**
     * @var int
     * @ORM\Column(name="resourceAmount", type="integer")
     */
    private $resourceAmount;

    /**
     * @var int
     * @ORM\Column(name="resourceMax", type="integer")
     */
    private $resourceMax;



    public function __construct()
    {
        $this->buildingLevel = 1;
        $this->resourceAmount = 1000;
        $this->resourceMax = 1500;
    }



    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return UserBuilding
     */
    public function setBuildingLevel($level)
    {
        $this->buildingLevel = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return int
     */
    public function getBuildingLevel()
    {
        return $this->buildingLevel;
    }

    /**
     * @param integer $userId
     * @return UserBuilding
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }


    /**
     * @param User $user
     * @return UserBuilding
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }






    /**
     * @param integer $buildingId
     * @return UserBuilding
     */
    public function setBuildingId($buildingId)
    {
        $this->buildingId = $buildingId;

        return $this;
    }

    /**
     * @return int
     */
    public function getBuildingId()
    {
        return $this->buildingId;
    }


    /**
     * @param Building $building
     * @return UserBuilding
     */
    public function setBuilding(Building $building)
    {
        $this->building = $building;
        return $this;
    }

    /**
     * @return Building
     */
    public function getBuilding()
    {
        return $this->building;
    }


    /**
     * @param integer $initialResource
     *
     * @return UserBuilding
     */
    public function setResourceAmount($initialResource)
    {
        $this->resourceAmount = $initialResource;

        return $this;
    }

    /**
     * @return integer
     */
    public function getResourceAmount()
    {
        return $this->resourceAmount;
    }

    /**
     * @return ProgressBuildingLevel
     */
    public function getProgressLevel()
    {
        return $this->progressLevel;
    }

    /**
     * @param ProgressBuildingLevel $progressLevel
     */
    public function setProgressLevel(ProgressBuildingLevel $progressLevel)
    {
        $this->progressLevel = $progressLevel;
    }

    /**
     * @return int
     */
    public function getResourceMax()
    {
        return $this->resourceMax;
    }

    /**
     * @param int $resourceMax
     */
    public function setResourceMax(int $resourceMax)
    {
        $this->resourceMax = $resourceMax;
    }

    /**
     * @return ProgressResourcesRenew
     */
    public function getResourcesRenew()
    {
        return $this->resourcesRenew;
    }

    /**
     * @param ProgressResourcesRenew $resourcesRenew
     */
    public function setResourcesRenew(ProgressResourcesRenew $resourcesRenew)
    {
        $this->resourcesRenew = $resourcesRenew;
    }
}

