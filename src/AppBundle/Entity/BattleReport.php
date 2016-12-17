<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BattleReport
 *
 * @ORM\Table(name="battle_report")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BattleReportRepository")
 */
class BattleReport
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
     * @ORM\Column(name="stolenGold", type="integer")
     */
    private $stolenGold;

    /**
     * @var int
     *
     * @ORM\Column(name="stolenWood", type="integer")
     */
    private $stolenWood;

    /**
     * @var int
     *
     * @ORM\Column(name="stolenStone", type="integer")
     */
    private $stolenStone;

    /**
     * @var int
     *
     * @ORM\Column(name="stolenFood", type="integer")
     */
    private $stolenFood;




    /**
     * @var int
     * @ORM\Column(name="winnerId", type="integer")
     */
    private $winnerId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="winnerReport")
     * @ORM\JoinColumn(name="winnerId", referencedColumnName="id")
     */
    private $winner;


    /**
     * @var int
     * @ORM\Column(name="looserId", type="integer")
     */
    private $looserId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="looserReport")
     * @ORM\JoinColumn(name="looserId", referencedColumnName="id")
     */
    private $looser;




    /**
     * @var int
     *
     * @ORM\Column(name="attackId", type="integer")
     */
    private $attackId;

    /**
     * @var Attack
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Attack", inversedBy="battleReport")
     * @ORM\JoinColumn(name="attackId", referencedColumnName="id")
     */
    private $attack;







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
     * Set stolenGold
     *
     * @param integer $stolenGold
     *
     * @return BattleReport
     */
    public function setStolenGold($stolenGold)
    {
        $this->stolenGold = $stolenGold;

        return $this;
    }

    /**
     * Get stolenGold
     *
     * @return int
     */
    public function getStolenGold()
    {
        return $this->stolenGold;
    }

    /**
     * Set stolenWood
     *
     * @param integer $stolenWood
     *
     * @return BattleReport
     */
    public function setStolenWood($stolenWood)
    {
        $this->stolenWood = $stolenWood;

        return $this;
    }

    /**
     * Get stolenWood
     *
     * @return int
     */
    public function getStolenWood()
    {
        return $this->stolenWood;
    }

    /**
     * Set stolenStone
     *
     * @param integer $stolenStone
     *
     * @return BattleReport
     */
    public function setStolenStone($stolenStone)
    {
        $this->stolenStone = $stolenStone;

        return $this;
    }

    /**
     * Get stolenStone
     *
     * @return int
     */
    public function getStolenStone()
    {
        return $this->stolenStone;
    }

    /**
     * Set stolenFood
     *
     * @param integer $stolenFood
     *
     * @return BattleReport
     */
    public function setStolenFood($stolenFood)
    {
        $this->stolenFood = $stolenFood;

        return $this;
    }

    /**
     * Get stolenFood
     *
     * @return int
     */
    public function getStolenFood()
    {
        return $this->stolenFood;
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
     * @return int
     */
    public function getWinnerId()
    {
        return $this->winnerId;
    }

    /**
     * @param int $winnerId
     */
    public function setWinnerId(int $winnerId)
    {
        $this->winnerId = $winnerId;
    }


    /**
     * @return int
     */
    public function getLooserId()
    {
        return $this->looserId;
    }


    /**
     * @param int $looserId
     */
    public function setLooserId(int $looserId)
    {
        $this->looserId = $looserId;
    }


    /**
     * @return User
     */
    public function getLooser()
    {
        return $this->looser;
    }

    /**
     * @param User $looser
     */
    public function setLooser(User $looser)
    {
        $this->looser = $looser;
    }


    /**
     * @return User
     */
    public function getWinner()
    {
        return $this->winner;
    }


    /**
     * @param User $winner
     */
    public function setWinner(User $winner)
    {
        $this->winner = $winner;
    }
}

