<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Attack
 *
 * @ORM\Table(name="attack")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AttackRepository")
 */
class Attack
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
     * @ORM\Column(name="arriveOn", type="datetime")
     */
    private $arriveOn;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=50)
     */
    private $status;


    /**
     * @var BattleReport
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\BattleReport", mappedBy="attack")
     */
    private $battleReport;







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
     * Get arrivedOn
     *
     * @return \DateTime
     */
    public function getArriveOn()
    {
        return $this->arriveOn;
    }

    /**
     * @param \DateTime $arriveOn
     *
     * @return Attack
     */
    public function setArriveOn(\DateTime $arriveOn)
    {
        $this->arriveOn = $arriveOn;
        return $this;
    }


    /**
     * @var int
     * @ORM\Column(name="attackerId", type="integer")
     */
    private $attackerId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="myAttacks")
     * @ORM\JoinColumn(name="attackerId", referencedColumnName="id")
     */
    private $attacker;


    /**
     * @var int
     * @ORM\Column(name="victimId", type="integer")
     */
    private $victimId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="attacksToMe")
     * @ORM\JoinColumn(name="victimId", referencedColumnName="id")
     */
    private $victim;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\AttackUnits", mappedBy="attack")
     */
    private $attackUnits;



    public function __construct()
    {
        $this->arriveOn = new DateTime();
        $this->attackUnits = new ArrayCollection();
    }


    /**
     * Get status
     *
     * @return DateTime
     */
    public function getStatus()
    {
        return $this->arriveOn;
    }

    /**
     * @param string $status
     *
     * @return Attack
     */
    public function setStatus(String $status)
    {
        $this->status = $status;
        return $this;
    }


    /**
     * @param BattleReport $battleReport
     * @return Attack
     */
    public function setBattleReport(BattleReport $battleReport)
    {
        $this->battleReport = $battleReport;

        return $this;
    }


    /**
     * @return BattleReport
     */
    public function getBattleReport()
    {
        return $this->battleReport;
    }


    /**
     * @return User
     */
    public function getAttacker()
    {
        return $this->attacker;
    }

    /**
     * @param User $attacker
     */
    public function setAttacker(User $attacker)
    {
        $this->attacker = $attacker;
    }


    /**
     * @return int
     */
    public function getAttackerId()
    {
        return $this->attackerId;
    }


    /**
     * @param int $attackerId
     */
    public function setAttackerId(int $attackerId)
    {
        $this->attackerId = $attackerId;
    }


    /**
     * @return User
     */
    public function getVictim()
    {
        return $this->victim;
    }

    /**
     * @param User $victim
     */
    public function setVictim(User $victim)
    {
        $this->victim = $victim;
    }


    /**
     * @return int
     */
    public function getVictimId()
    {
        return $this->victimId;
    }

    /**
     * @param int $victimId
     */
    public function setVictimId(int $victimId)
    {
        $this->victimId = $victimId;
    }

    /**
     * @return ArrayCollection
     */
    public function getAttackUnits()
    {
        return $this->attackUnits;
    }

    /**
     * @param AttackUnits $attackUnits
     */
    public function setAttackUnits(AttackUnits $attackUnits)
    {
        $this->attackUnits = $attackUnits;
    }
}

