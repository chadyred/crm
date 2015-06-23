<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ActivityType
 *
 * @ORM\Table(name="crm_activity_type")
 * @ORM\Entity
 */
class ActivityType
{
    const CALL = 1;
    const RDV = 2;
    const CAMPAIGN = 3;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $title;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     * @Assert\NotNull()
     * @Assert\Range(min="1", max="3")
     */
    private $type;

    /**
     * @var Activity
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\Activity", mappedBy="type", cascade="all")
     */
    private $activities;

    /**
     * Constructor
     */
    public function __construct($name = null, $title = null, $type = null)
    {
        $this->name = $name;
        $this->title = $title;
        $this->type = $type;
        $this->activities = new ArrayCollection();
    }

    /**
     * ToString
     */
    public function __toString()
    {
        return $this->getTitle();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return ActivityType
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set type
     *
     * @param integer $type
     * @return ActivityType
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add activities
     *
     * @param \Enigmatic\CRMBundle\Entity\Activity $activities
     * @return ActivityType
     */
    public function addActivity(\Enigmatic\CRMBundle\Entity\Activity $activities)
    {
        $this->activities[] = $activities;

        return $this;
    }

    /**
     * Remove activities
     *
     * @param \Enigmatic\CRMBundle\Entity\Activity $activities
     */
    public function removeActivity(\Enigmatic\CRMBundle\Entity\Activity $activities)
    {
        $this->activities->removeElement($activities);
    }

    /**
     * Get activities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return ActivityType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
}
