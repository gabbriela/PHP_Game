<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AttackUnits
 *
 * @ORM\Table(name="attack_units")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttackUnitsRepository")
 */
class AttackUnits
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
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;


    /**
     * @var int
     * @ORM\Column(name="attackId", type="integer")
     */
    private $attackId;

    /**
     * @var Attack
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Attack", inversedBy="attackUnits")
     * @ORM\JoinColumn(name="attackId", referencedColumnName="id")
     */
    private $attack;



    /**
     * @var int
     * @ORM\Column(name="userUnitId", type="integer")
     */
    private $userUnitId;

    /**
     * @var UserUnits
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\UserUnits", inversedBy="attackUnits")
     * @ORM\JoinColumn(name="userUnitId", referencedColumnName="id")
     */
    private $userUnit;







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
     * @return AttackUnits
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
     * @return Attack
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * @param Attack $attack
     */
    public function setAttack(Attack $attack)
    {
        $this->attack = $attack;
    }


    /**
     * @return int
     */
    public function getAttackId()
    {
        return $this->attackId;
    }

    /**
     * @param int $attackId
     */
    public function setAttackId(int $attackId)
    {
        $this->attackId = $attackId;
    }


    /**
     * @return UserUnits
     */
    public function getUserUnit()
    {
        return $this->userUnit;
    }

    /**
     * @param UserUnits $userUnit
     */
    public function setUserUnit(UserUnits $userUnit)
    {
        $this->userUnit = $userUnit;
    }


    /**
     * @return int
     */
    public function getUserUnitId()
    {
        return $this->userUnitId;
    }

    /**
     * @param int $userUnitId
     */
    public function setUserUnitId(int $userUnitId)
    {
        $this->userUnitId = $userUnitId;
    }
}

