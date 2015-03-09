<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * User
 *
 * @ORM\Table(name="crm_user")
 * @ORM\Entity(repositoryClass="Enigmatic\CRMBundle\Repository\UserRepository")
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
     * @var \UserBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="UserBundle\Entity\User", cascade="all"))
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $user;

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
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\Activity", mappedBy="user", cascade="all")
     */
    private $activities;

    /**
     * @var AgencyUser
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AgencyUser", mappedBy="user", cascade="all")
     * @OrderBy({"dateCreated" = "DESC"})
     */
    private $agencies;

    /**
     * @var AgencyUser
     */
    private $newAgency;

    /**
     * @var AccountOwner
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AccountOwner", mappedBy="user", cascade="all")
     */
    private $assignedAccount;


    /**
     * Constructor
     */
    public function __construct(\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
        $this->activities = new ArrayCollection();
        $this->assignedAccount = new ArrayCollection();
        $this->agencies = new ArrayCollection();
        $this->newAgency = new AgencyUser($this);
    }

    /**
     * ToString
     */
    public function __toString()
    {
        return $this->getFirstname().' '.$this->getName();
    }

    public function getUserWithAgencyName() {
        return $this->getFirstname().' '.$this->getName().' ('.$this->getAgency()->getName().')';

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
        return strtoupper($this->name);
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
     * Get agency
     *
     * @return \Enigmatic\CRMBundle\Entity\Agency
     */
    public function getAgency()
    {
        if (count($this->getAgencies()))
            return $this->getAgencies()->first()->getAgency();
        else
            return null;
    }

    /**
     * set newAgency
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyUser $agency
     * @return User
     */
    public function setNewAgency(AgencyUser $agency)
    {
        return $this->newAgency = $agency;
    }

    /**
     * Get newAgency
     *
     * @return \Enigmatic\CRMBundle\Entity\AgencyUser
     */
    public function getNewAgency()
    {
        return $this->newAgency;
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


    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     * @return User
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->getUser()->getEmail();
    }

    /**
     * Get plainPassword
     *
     * @return string
     */
    public function getPlainPassword()
    {
        return $this->getUser()->getPlainPassword();
    }

    /**
     * Set plainPassword
     *
     * @param string $password
     * @return User
     */
    public function setPlainPassword($password)
    {
        $this->getUser()->setPlainPassword($password);
        return $this;
    }

    /**
     * Get confirmationToken
     *
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->getUser()->getConfirmationToken();
    }

    /**
     * Set confirmationToken
     *
     * @param string $token
     * @return User
     */
    public function setConfirmationToken($token)
    {
        $this->getUser()->setConfirmationToken($token);
        return $this;
    }

    /**
     * Set enabled
     *
     * @param bool $enabled
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->getUser()->setEnabled($enabled);
        return $this;
    }

    /**
     * Is enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->getUser()->isEnabled();
    }

    /**
     * Is locked
     *
     * @return bool
     */
    public function isLocked()
    {
        return $this->getUser()->isLocked();
    }

    /**
     * get lastLogin
     *
     * @return \Datetime
     */
    public function getLastLogin()
    {
        return $this->getUser()->getLastLogin();
    }

    /**
     * Add role
     *
     * @param string $role
     * @return User
     */
    public function addRole($role)
    {
        $this->getUser()->addRole($role);
        return $this;
    }

    /**
     * Has role
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->getUser()->hasRole($role);
    }

}
