<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * ProgressBuilding
 *
 * @ORM\Table(name="progress_building")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgressBuildingRepository")
 */
class ProgressBuilding
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
     * @var \DateTime
     *
     * @ORM\Column(name="readyOn", type="datetime")
     */
    private $readyOn;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;


    /**
     * @var int
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userProgressBuildings")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Building", inversedBy="buildingProgressBuildings")
     * @ORM\JoinColumn(name="buildingId", referencedColumnName="id")
     */
    private $building;


    public function __construct()
    {
        $this->readyOn = new \DateTime('now');
        $this->status = "progress";
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
     * Set readyOn
     *
     * @param \DateTime $readyOn
     *
     * @return ProgressBuilding
     */
    public function setReadyOn(\DateTime $readyOn)
    {
        $this->readyOn = $readyOn;

        return $this;
    }

    /**
     * Get readyOn
     *
     * @return \DateTime
     */
    public function getReadyOn()
    {
        return $this->readyOn;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return ProgressBuilding
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

     /**
     * @return Building
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param Building $building
     */
    public function setBuilding(Building $building)
    {
        $this->building = $building;
    }

    /**
     * @return int
     */
    public function getBuildingId()
    {
        return $this->buildingId;
    }

    /**
     * @param int $buildingId
     */
    public function setBuildingId(int $buildingId)
    {
        $this->buildingId = $buildingId;
    }


}

