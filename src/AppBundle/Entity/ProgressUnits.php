<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgressUnits
 *
 * @ORM\Table(name="progress_units")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgressUnitsRepository")
 */
class ProgressUnits
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
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;



    /**
     * @var int
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userProgressUnits")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;


    /**
     * @var int
     * @ORM\Column(name="unitId", type="integer")
     */
    private $unitId;

    /**
     * @var Unit
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit", inversedBy="progressUnits")
     * @ORM\JoinColumn(name="unitId", referencedColumnName="id")
     */
    private $unit;


    public function __construct()
    {
        $this->setStatus("progress");
        $this->setReadyOn(new \DateTime('now'));
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
     * @return ProgressUnits
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
     * Set status
     *
     * @param string $status
     *
     * @return ProgressUnits
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

    /**
     * @return int
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * @param int $unitId
     */
    public function setUnitId(int $unitId)
    {
        $this->unitId = $unitId;
    }

    /**
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param Unit $unit
     */
    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;
    }

}

