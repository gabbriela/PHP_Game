<?php

namespace AppBundle\Entity;

use AppBundle\AppBundle;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Unit
 *
 * @ORM\Table(name="units")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UnitRepository")
 */
class Unit
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=800)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="buildingLevel", type="integer")
     */
    private $buildingLevel;

    /**
     * @var int
     *
     * @ORM\Column(name="builldTime", type="integer")
     */
    private $builldTime;

    /**
     * @var int
     *
     * @ORM\Column(name="lifePoints", type="integer")
     */
    private $lifePoints;

    /**
     * @var int
     *
     * @ORM\Column(name="damage", type="integer")
     */
    private $damage;

    /**
     * @var int
     *
     * @ORM\Column(name="initialFood", type="integer")
     */
    private $initialFood;

    /**
     * @var int
     *
     * @ORM\Column(name="foodPerDay", type="integer")
     */
    private $foodPerDay;

    /**
     * @var int
     *
     * @ORM\Column(name="population", type="integer")
     */
    private $population;


    /**
     * @var int
     *
     * @ORM\Column(name="buildingId", type="integer")
     */
    private $buildingId;

    /**
     * @var Building
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Building", inversedBy="units")
     * @ORM\JoinColumn(name="buildingId", referencedColumnName="id")
     */
    private $building;



    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserUnits", mappedBy="unit")
     */
    private $userUnits;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgressUnits", mappedBy="unit")
     */
    private $progressUnits;



    public function __construct()
    {
        $this->userUnits = new ArrayCollection();
        $this->progressUnits = new ArrayCollection();
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
     * @return Unit
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
     * Set description
     *
     * @param string $description
     *
     * @return Unit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set buildingLevel
     *
     * @param integer $buildingLevel
     *
     * @return Unit
     */
    public function setBuildingLevel($buildingLevel)
    {
        $this->buildingLevel = $buildingLevel;

        return $this;
    }

    /**
     * Get buildingLevel
     *
     * @return int
     */
    public function getBuildingLevel()
    {
        return $this->buildingLevel;
    }

    /**
     * Set builldTime
     *
     * @param integer $builldTime
     *
     * @return Unit
     */
    public function setBuilldTime($builldTime)
    {
        $this->builldTime = $builldTime;

        return $this;
    }

    /**
     * Get builldTime
     *
     * @return int
     */
    public function getBuilldTime()
    {
        return $this->builldTime;
    }

    /**
     * Set lifePoints
     *
     * @param integer $lifePoints
     *
     * @return Unit
     */
    public function setLifePoints($lifePoints)
    {
        $this->lifePoints = $lifePoints;

        return $this;
    }

    /**
     * Get lifePoints
     *
     * @return int
     */
    public function getLifePoints()
    {
        return $this->lifePoints;
    }

    /**
     * Set damage
     *
     * @param integer $damage
     *
     * @return Unit
     */
    public function setDamage($damage)
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * Get damage
     *
     * @return int
     */
    public function getDamage()
    {
        return $this->damage;
    }

    /**
     * Set initialFood
     *
     * @param integer $initialFood
     *
     * @return Unit
     */
    public function setInitialFood($initialFood)
    {
        $this->initialFood = $initialFood;

        return $this;
    }

    /**
     * Get initialFood
     *
     * @return int
     */
    public function getInitialFood()
    {
        return $this->initialFood;
    }

    /**
     * Set foodPerDay
     *
     * @param integer $foodPerDay
     *
     * @return Unit
     */
    public function setFoodPerDay($foodPerDay)
    {
        $this->foodPerDay = $foodPerDay;

        return $this;
    }

    /**
     * Get foodPerDay
     *
     * @return int
     */
    public function getFoodPerDay()
    {
        return $this->foodPerDay;
    }

    /**
     * Set population
     *
     * @param integer $population
     *
     * @return Unit
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return int
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * @param integer $buildingId
     * @return Unit
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
     * @param \AppBundle\Entity\Building $building
     * @return Unit
     */
    public function setBuilding(Building $building = null)
    {
        $this->building = $building;
        return $this;
    }

    /**
     * @return \AppBundle\Entity\Building
     */
    public function getBuilding()
    {
        return $this->building;
    }



    /**
     * @return ArrayCollection
     */
    public function getUserUnits()
    {
        return $this->userUnits;
    }

    /**
     * @param \AppBundle\Entity\UserUnits $userUnits
     * @return Unit
     */
    public function addUserUnits(UserUnits $userUnits)
    {
        $this->userUnits[] = $userUnits;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getProgressUnits()
    {
        return $this->progressUnits;
    }

    /**
     * @param ProgressUnits $progressUnits
     */
    public function setProgressUnits(ProgressUnits $progressUnits)
    {
        $this->progressUnits = $progressUnits;
    }

}

