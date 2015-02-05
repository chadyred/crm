<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Account
 *
 * @ORM\Table(name="crm_account")
 * @ORM\Entity
 */
class Account
{
    const VALID = 1;
    const REMOVED = 2;
    const ARCHIVED = 3;

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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=14)
     * @Assert\NotBlank()
     * @Assert\Length(min="14", max="14")
     */
    private $siret;
    // @rp_todo : validation du siret

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="addressCpl", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $addressCpl;

    /**
     * @var \Enigmatic\CityBundle\Entity\City
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CityBundle\Entity\City")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12, nullable=true)
     * @Assert\Regex(pattern="/^([+]{1}[0-9]{1})?[0-9]{10}$/", message="phone.invalid_format")
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=12, nullable=true)
     * @Assert\Regex(pattern="/^([+]{1}[0-9]{1})?[0-9]{10}$/", message="phone.invalid_format")
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="activity", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $activity;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $dateCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateUpdated", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $dateUpdated;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="smallint")
     * @Assert\NotNull()
     * @Assert\Range(min="1", max="3")
     */
    private $state;

    /**
     * @var Contact
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\Contact", mappedBy="account")
     */
    private $contacts;

    /**
     * @var Activity
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\Activity", mappedBy="account")
     */
    private $activities;

    /**
     * @var AccountOwner
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AccountOwner", mappedBy="account")
     */
    private $owners;

    /**
     * @var AgencyAccount
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AgencyAccount", mappedBy="account")
     */
    private $agencies;


    /**
     * Constructor
     */
    public function __construct($state = self::VALID)
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
        $this->state = $state;
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
     * Set name
     *
     * @param string $name
     * @return Account
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
     * Set siret
     *
     * @param string $siret
     * @return Account
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string 
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Account
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set addressCpl
     *
     * @param string $addressCpl
     * @return Account
     */
    public function setAddressCpl($addressCpl)
    {
        $this->addressCpl = $addressCpl;

        return $this;
    }

    /**
     * Get addressCpl
     *
     * @return string 
     */
    public function getAddressCpl()
    {
        return $this->addressCpl;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Account
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return Account
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set activity
     *
     * @param string $activity
     * @return Account
     */
    public function setActivity($activity)
    {
        $this->activity = $activity;

        return $this;
    }

    /**
     * Get activity
     *
     * @return string 
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Account
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Account
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     * @return Account
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime 
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return Account
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set city
     *
     * @param \Enigmatic\CityBundle\Entity\City $city
     * @return Account
     */
    public function setCity(\Enigmatic\CityBundle\Entity\City $city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Enigmatic\CityBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Add contacts
     *
     * @param \Enigmatic\CRMBundle\Entity\Contact $contacts
     * @return Account
     */
    public function addContact(\Enigmatic\CRMBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \Enigmatic\CRMBundle\Entity\Contact $contacts
     */
    public function removeContact(\Enigmatic\CRMBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * Add activities
     *
     * @param \Enigmatic\CRMBundle\Entity\Activity $activities
     * @return Account
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
     * Add owners
     *
     * @param \Enigmatic\CRMBundle\Entity\AccountOwner $owners
     * @return Account
     */
    public function addOwner(\Enigmatic\CRMBundle\Entity\AccountOwner $owners)
    {
        $this->owners[] = $owners;

        return $this;
    }

    /**
     * Remove owners
     *
     * @param \Enigmatic\CRMBundle\Entity\AccountOwner $owners
     */
    public function removeOwner(\Enigmatic\CRMBundle\Entity\AccountOwner $owners)
    {
        $this->owners->removeElement($owners);
    }

    /**
     * Get owners
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOwners()
    {
        return $this->owners;
    }

    /**
     * Add agencies
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyAccount $agencies
     * @return Account
     */
    public function addAgency(\Enigmatic\CRMBundle\Entity\AgencyAccount $agencies)
    {
        $this->agencies[] = $agencies;

        return $this;
    }

    /**
     * Remove agencies
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyAccount $agencies
     */
    public function removeAgency(\Enigmatic\CRMBundle\Entity\AgencyAccount $agencies)
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
}
