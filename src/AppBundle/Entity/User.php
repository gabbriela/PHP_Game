<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=100, unique=true)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;


    /**
     * @var Map
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Map", mappedBy="user")
     */
    private $map;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserBuilding", mappedBy="user")
     */
    private $userBuildings;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserResource", mappedBy="user")
     */
    private $userResources;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UserUnits", mappedBy="user")
     */
    private $userUnits;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Attack", mappedBy="attacker")
     */
    private $myAttacks;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Attack", mappedBy="victim")
     */
    private $attacksToMe;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgressBuilding", mappedBy="user")
     */
    private $userProgressBuildings;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgressResourcesRenew", mappedBy="user")
     */
    private $userResourcesRenew;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgressBuildingLevel", mappedBy="user")
     */
    private $userProgressBuildingsLevel;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ProgressUnits", mappedBy="user")
     */
    private $userProgressUnits;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\BattleReport", mappedBy="winner")
     */
    private $winnerReport;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\BattleReport", mappedBy="looser")
     */
    private $looserReport;


    public function __construct()
    {
        $this->userBuildings = new ArrayCollection();
        $this->userResources = new ArrayCollection();
        $this->userUnits = new ArrayCollection();
        $this->myAttacks = new ArrayCollection();
        $this->attacksToMe = new ArrayCollection();
        $this->userProgressBuildings = new ArrayCollection();
        $this->userProgressBuildingsLevel = new ArrayCollection();
        $this->userResourcesRenew = new ArrayCollection();
        $this->userProgressUnits = new ArrayCollection();
        $this->winnerReport = new ArrayCollection();
        $this->looserReport = new ArrayCollection();
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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        return [];
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return \AppBundle\Entity\Map
     */
    public function getMap()
    {
        return $this->map;
    }

    /**
     * @param \AppBundle\Entity\Map $map
     * @return User;
     */
    public function setMap(Map $map)
    {
        $this->map = $map;
        return $this;
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
     * @return User
     */
    public function addUserBuildings(UserBuilding $userBuilding)
    {
        $this->userBuildings[] = $userBuilding;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserResources()
    {
        return $this->userResources;
    }

    /**
     * @param \AppBundle\Entity\UserResource $userResources
     * @return User
     */
    public function addUserResources(UserResource $userResources)
    {
        $this->userResources[] = $userResources;
        return $this;
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
     * @return User
     */
    public function addUserUnits(UserUnits $userUnits)
    {
        $this->userResources[] = $userUnits;
        return $this;
    }


    /**
     * @return ArrayCollection
     */
    public function getAttacksToMe()
    {
        return $this->attacksToMe;
    }

    /**
     * @param Attack $attacksToMe
     */
    public function setAttacksToMe(Attack $attacksToMe)
    {
        $this->attacksToMe = $attacksToMe;
    }

    /**
     * @return ArrayCollection
     */
    public function getMyAttacks()
    {
        return $this->myAttacks;
    }

    /**
     * @param Attack $myAttacks
     */
    public function setMyAttacks(Attack $myAttacks)
    {
        $this->myAttacks = $myAttacks;
    }


    /**
     * @return ArrayCollection
     */
    public function getUserProgressBuildings()
    {
        return $this->userProgressBuildings;
    }

    /**
     * @param ProgressBuilding $userProgressBuildings
     */
    public function setUserProgressBuildings(ProgressBuilding $userProgressBuildings)
    {
        $this->userProgressBuildings = $userProgressBuildings;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserProgressBuildingsLevel()
    {
        return $this->userProgressBuildingsLevel;
    }

    /**
     * @param ProgressBuildingLevel $userProgressBuildingsLevel
     */
    public function setUserProgressBuildingsLevel(ProgressBuildingLevel $userProgressBuildingsLevel)
    {
        $this->userProgressBuildingsLevel = $userProgressBuildingsLevel;
    }


    /**
     * @return ArrayCollection
     */
    public function getUserResourcesRenew()
    {
        return $this->userResourcesRenew;
    }

    /**
     * @param ProgressResourcesRenew $userResourcesRenew
     */
    public function setUserResourcesRenew(ProgressResourcesRenew $userResourcesRenew)
    {
        $this->userResourcesRenew = $userResourcesRenew;
    }

    /**
     * @return ArrayCollection
     */
    public function getUserProgressUnits()
    {
        return $this->userProgressUnits;
    }

    /**
     * @param ProgressUnits $userProgressUnits
     */
    public function setUserProgressUnits(ProgressUnits $userProgressUnits)
    {
        $this->userProgressUnits = $userProgressUnits;
    }


    /**
     * @return ArrayCollection
     */
    public function getLooserReport()
    {
        return $this->looserReport;
    }

    /**
     * @param BattleReport $looserReport
     */
    public function setLooserReport(BattleReport $looserReport)
    {
        $this->looserReport = $looserReport;
    }

    /**
     * @return ArrayCollection
     */
    public function getWinnerReport()
    {
        return $this->winnerReport;
    }

    /**
     * @param BattleReport $winnerReport
     */
    public function setWinnerReport(BattleReport $winnerReport)
    {
        $this->winnerReport = $winnerReport;
    }
}

