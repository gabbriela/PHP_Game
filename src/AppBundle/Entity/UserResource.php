<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserResource
 *
 * @ORM\Table(name="user_resource")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserResourceRepository")
 */
class UserResource
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
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;


    /**
     * @var int
     * @ORM\Column(name="userId", type="integer")
     */
    private $userId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userResources")
     * @ORM\JoinColumn(name="userId", referencedColumnName="id")
     */
    private $user;



    /**
     * @var int
     * @ORM\Column(name="resourceId", type="integer")
     */
    private $resourceId;

    /**
     * @var Resources
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Resources", inversedBy="userResources")
     * @ORM\JoinColumn(name="resourceId", referencedColumnName="id")
     */
    private $resource;





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
     * Set amount
     *
     * @param integer $amount
     *
     * @return UserResource
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }




    /**
     * @param integer $userId
     * @return UserResource
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
     * @return UserResource
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





    /**
     * @param integer $resourceId
     * @return UserResource
     */
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

    /**
     * @return int
     */
    public function getResourceId()
    {
        return $this->resourceId;
    }


    /**
     * @param Resources $resources
     * @return UserResource
     */
    public function addResource(Resources $resources)
    {
        $this->resource = $resources;
        return $this;
    }

    /**
     * @return Resources
     */
    public function getResources()
    {
        return $this->resource;
    }


}

