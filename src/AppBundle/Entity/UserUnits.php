<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserUnits
 *
 * @ORM\Table(name="user_units")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserUnitsRepository")
 */
class UserUnits
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
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="lifePoints", type="integer")
     */
    private $lifePoints;



    /**
     * @var int
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userUnits")
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Unit", inversedBy="userUnits")
     * @ORM\JoinColumn(name="unitId", referencedColumnName="id")
     */
    private $unit;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AttackUnits", mappedBy="userUnit")
     */
    private $attackUnits;



    public function __construct()
    {
        $this->status = 'free';
    }

    /**
     * @return string
     */
    public function getUnitName()
    {
        return $this->unit->getName();
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
     * Set status
     *
     * @param string $status
     *
     * @return UserUnits
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
     * Set lifePoints
     *
     * @param integer $lifePoints
     *
     * @return UserUnits
     */
    public function setLifePoints($lifePoints)
    {
        $this->lifePoints = $lifePoints;

        return $this;
    }

    /**
     * Get lifePoints
     *
     * @return integer
     */
    public function getLifePoints()
    {
        return $this->lifePoints;
    }



    /**
     * @param integer $userId
     * @return UserUnits
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
     * @return UserUnits
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


    //Unit
    /**
     * @param integer $unitId
     * @return UserUnits
     */
    public function setUnitId($unitId)
    {
        $this->unitId = $unitId;

        return $this;
    }

    /**
     * @return int
     */
    public function getUnitId()
    {
        return $this->unitId;
    }


    /**
     * @param Unit $unit
     * @return UserUnits
     */
    public function setUnit(Unit $unit)
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }

}

