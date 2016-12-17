<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgressBuildingLevel
 *
 * @ORM\Table(name="progress_building_level")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgressBuildingLevelRepository")
 */
class ProgressBuildingLevel
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
     *
     * @ORM\Column(name="userBuildingId", type="integer")
     */
    private $userBuildingId;

    /**
     * @var UserBuilding
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\UserBuilding", inversedBy="progressLevel")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userProgressBuildingsLevel")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;


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
     * @return ProgressBuildingLevel
     */
    public function setReadyOn($readyOn)
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
     * @return int
     */
    public function getUserBuildingId()
    {
        return $this->userBuildingId;
    }

    /**
     * @param int $userBuildingId
     */
    public function setUserBuildingId(int $userBuildingId)
    {
        $this->userBuildingId = $userBuildingId;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status)
    {
        $this->status = $status;
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
}

