<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgressResourcesRenew
 *
 * @ORM\Table(name="progress_resources_renew")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgressResourcesRenewRepository")
 */
class ProgressResourcesRenew
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
     *
     * @ORM\Column(name="resourceAmount", type="integer")
     */
    private $resourceAmount;

    /**
     * @var int
     *
     * @ORM\Column(name="time", type="integer")
     */
    private $time;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastUpdateOn", type="datetime")
     */
    private $lastUpdateOn;


    /**
     * @var int
     *
     * @ORM\Column(name="userBuildingId", type="integer")
     */
    private $userBuildingId;

    /**
     * @var UserBuilding
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\UserBuilding", inversedBy="resourcesRenew")
     * @ORM\JoinColumn(name="userBuildingId", referencedColumnName="id")
     */
    private $userBuilding;


    /**
     * @var int
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userResourcesRenew")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;




    public function __construct()
    {
        $this->lastUpdateOn = new \DateTime('now');
        $this->resourceAmount = 100;
        $this->time = 200;
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
     * Set resourceAmount
     *
     * @param integer $resourceAmount
     *
     * @return ProgressResourcesRenew
     */
    public function setResourceAmount($resourceAmount)
    {
        $this->resourceAmount = $resourceAmount;

        return $this;
    }

    /**
     * Get resourceAmount
     *
     * @return int
     */
    public function getResourceAmount()
    {
        return $this->resourceAmount;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return ProgressResourcesRenew
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set lastUpdateOn
     *
     * @param \DateTime $lastUpdateOn
     *
     * @return ProgressResourcesRenew
     */
    public function setLastUpdateOn($lastUpdateOn)
    {
        $this->lastUpdateOn = $lastUpdateOn;

        return $this;
    }

    /**
     * Get lastUpdateOn
     *
     * @return \DateTime
     */
    public function getLastUpdateOn()
    {
        return $this->lastUpdateOn;
    }


    /**
     * @param int $userBuildingId
     */
    public function setUserBuildingId(int $userBuildingId)
    {
        $this->userBuildingId = $userBuildingId;
    }


    /**
     * @return int
     */
    public function getUserBuildingId()
    {
        return $this->userBuildingId;
    }


    /**
     * @return UserBuilding
     */
    public function getUserBuilding()
    {
        return $this->userBuilding;
    }

    /**
     * @param UserBuilding $userBuilding
     */
    public function setUserBuilding(UserBuilding $userBuilding)
    {
        $this->userBuilding = $userBuilding;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
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
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}

