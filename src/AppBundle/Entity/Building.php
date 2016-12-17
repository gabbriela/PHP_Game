<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Building
 *
 * @ORM\Table(name="building")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BuildingRepository")
 */
class Building
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="level_required", type="integer")
     */
    private $levelRequired;

    /**
     * @var int
     *
     * @ORM\Column(name="build_time", type="integer")
     */
    private $buildTime;

    /**
     * @var int
     *
     * @ORM\Column(name="wood_cost", type="integer")
     */
    private $woodCost;

    /**
     * @var int
     *
     * @ORM\Column(name="stone_cost", type="integer")
     */
    private $stoneCost;

    /**
     * @var int
     *
     * @ORM\Column(name="gold_cost", type="integer")
     */
    private $goldCost;

    /**
     * @var int
     * @ORM\Column(name="initial_resource", type="integer")
     */
    private $initialResource;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserBuilding", mappedBy="building")
     */
    private $userBuildings;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Unit", mappedBy="building")
     */
    private $units;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgressBuilding", mappedBy="building")
     */
    private $buildingProgressBuildings;



    public function __construct()
    {
        $this->userBuildings = new ArrayCollection();
        $this->units = new ArrayCollection();
        $this->initialResource = 0;
        $this->buildingProgressBuildings = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Building
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set levelRequired
     *
     * @param integer $levelRequired
     *
     * @return Building
     */
    public function setLevelRequired($levelRequired)
    {
        $this->levelRequired = $levelRequired;

        return $this;
    }

    /**
     * Get levelRequired
     *
     * @return int
     */
    public function getLevelRequired()
    {
        return $this->levelRequired;
    }

    /**
     * Set buildTime
     *
     * @param integer $buildTime
     *
     * @return Building
     */
    public function setBuildTime($buildTime)
    {
        $this->buildTime = $buildTime;

        return $this;
    }

    /**
     * Get buildTime
     *
     * @return int
     */
    public function getBuildTime()
    {
        return $this->buildTime;
    }

    /**
     * Set woodCost
     *
     * @param integer $woodCost
     *
     * @return Building
     */
    public function setWoodCost($woodCost)
    {
        $this->woodCost = $woodCost;

        return $this;
    }

    /**
     * Get woodCost
     *
     * @return int
     */
    public function getWoodCost()
    {
        return $this->woodCost;
    }

    /**
     * Set stoneCost
     *
     * @param integer $stoneCost
     *
     * @return Building
     */
    public function setStoneCost($stoneCost)
    {
        $this->stoneCost = $stoneCost;

        return $this;
    }

    /**
     * Get stoneCost
     *
     * @return int
     */
    public function getStoneCost()
    {
        return $this->stoneCost;
    }

    /**
     * Set goldCost
     *
     * @param integer $goldCost
     *
     * @return Building
     */
    public function setGoldCost($goldCost)
    {
        $this->goldCost = $goldCost;

        return $this;
    }

    /**
     * Get goldCost
     *
     * @return int
     */
    public function getGoldCost()
    {
        return $this->goldCost;
    }



    /**
     * @return ArrayCollection
     */
    public function getUserBuildings()
    {
        return $this->userBuildings;
    }

    /**
     * @param \AppBundle\Entity\UserBuilding $userBuilding
     * @return Building
     */
    public function addUserBuildings(UserBuilding $userBuilding)
    {
        $this->userBuildings[] = $userBuilding;
        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * @param ArrayCollection $units
     * @return Building
     */
    public function setUnits(ArrayCollection $units)
    {
        $this->units = $units;

        return $this;
    }



    /**
     * @param integer $initialResource
     *
     * @return Building
     */
    public function setInitialResource($initialResource)
    {
        $this->initialResource = $initialResource;

        return $this;
    }

    /**
     * @return integer
     */
    public function getInitialResource()
    {
        return $this->initialResource;
    }


    /**
     * @return ArrayCollection
     */
    public function getBuildingProgressBuildings()
    {
        return $this->buildingProgressBuildings;
    }

    /**
     * @param ProgressBuilding $buildingProgressBuildings
     */
    public function setBuildingProgressBuildings(ProgressBuilding $buildingProgressBuildings)
    {
        $this->buildingProgressBuildings = $buildingProgressBuildings;
    }
}

