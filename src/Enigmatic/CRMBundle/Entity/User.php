<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="crm_user")
 * @ORM\Entity
 */
class User
{
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
     * @ORM\Column(name="firstname", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45)
     * @Assert\NotBlank()
     * @Assert\Length(max="45")
     */
    private $name;

    /**
     * @var Activity
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\Activity", mappedBy="user")
     */
    private $activities;

    /**
     * @var AgencyUser
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AgencyUser", mappedBy="user")
     */
    private $agencies;

    /**
     * @var AccountOwner
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AccountOwner", mappedBy="user")
     */
    private $assignedAccount;


    /**
     * Constructor
     */
    public function __construct()
    {

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
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string 
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
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

    /**
     * Add activities
     *
     * @param \Enigmatic\CRMBundle\Entity\Activity $activities
     * @return User
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
     * Add agencies
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyUser $agencies
     * @return User
     */
    public function addAgency(\Enigmatic\CRMBundle\Entity\AgencyUser $agencies)
    {
        $this->agencies[] = $agencies;

        return $this;
    }

    /**
     * Remove agencies
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyUser $agencies
     */
    public function removeAgency(\Enigmatic\CRMBundle\Entity\AgencyUser $agencies)
    {
        $this->agencies->removeElement($agencies);
    }

    /**
     * Get agencies
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAgencies()
    {
        return $this->agencies;
    }

    /**
     * Add assignedAccount
     *
     * @param \Enigmatic\CRMBundle\Entity\AccountOwner $assignedAccount
     * @return User
     */
    public function addAssignedAccount(\Enigmatic\CRMBundle\Entity\AccountOwner $assignedAccount)
    {
        $this->assignedAccount[] = $assignedAccount;

        return $this;
    }

    /**
     * Remove assignedAccount
     *
     * @param \Enigmatic\CRMBundle\Entity\AccountOwner $assignedAccount
     */
    public function removeAssignedAccount(\Enigmatic\CRMBundle\Entity\AccountOwner $assignedAccount)
    {
        $this->assignedAccount->removeElement($assignedAccount);
    }

    /**
     * Get assignedAccount
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAssignedAccount()
    {
        return $this->assignedAccount;
    }
}
