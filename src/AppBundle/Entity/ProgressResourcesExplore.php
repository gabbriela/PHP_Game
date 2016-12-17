<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgressResourcesExplore
 *
 * @ORM\Table(name="progress_resources_explore")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgressResourcesExploreRepository")
 */
class ProgressResourcesExplore
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
     * @return ProgressResourcesExplore
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
}

