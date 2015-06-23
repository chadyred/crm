<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agency
 *
 * @ORM\Table(name="crm_agency")
 * @ORM\Entity(repositoryClass="Enigmatic\CRMBundle\Repository\AgencyRepository")
 */
class Agency
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $address;

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
     * @ORM\Column(name="addressCpl", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $addressCpl;

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
     * @var AgencyUser
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AgencyUser", mappedBy="agency")
     */
    private $users;

    /**
     * @var AgencyAccount
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AgencyAccount", mappedBy="agency")
     */
    private $accounts;

    /**
     * @var Contact
     *
     * @ORM\ManyToMany(targetEntity="Enigmatic\CRMBundle\Entity\Contact", inversedBy="agencies")
     * @ORM\JoinColumn(nullable=true)
     * @ORM\JoinTable(name="crm_agency_contact")
     */
    private $contacts;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
        $this->contacts = new ArrayCollection();
    }

    /**
     * ToString
     */
    public function __toString()
    {
        return $this->getName();
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
     * @return Agency
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
     * Set address
     *
     * @param string $address
     * @return Agency
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
     * @return Agency
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Agency
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
     * @return Agency
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
     * Set city
     *
     * @param \Enigmatic\CityBundle\Entity\City $city
     * @return Agency
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
     * Add users
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyUser $users
     * @return Agency
     */
    public function addUser(\Enigmatic\CRMBundle\Entity\AgencyUser $users)
    {
        $this->users[] = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyUser $users
     */
    public function removeUser(\Enigmatic\CRMBundle\Entity\AgencyUser $users)
    {
        $this->users->removeElement($users);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add accounts
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyAccount $accounts
     * @return Agency
     */
    public function addAccount(\Enigmatic\CRMBundle\Entity\AgencyAccount $accounts)
    {
        $this->accounts[] = $accounts;

        return $this;
    }

    /**
     * Remove accounts
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyAccount $accounts
     */
    public function removeAccount(\Enigmatic\CRMBundle\Entity\AgencyAccount $accounts)
    {
        $this->accounts->removeElement($accounts);
    }

    /**
     * Get accounts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

    /**
     * Add contacts
     *
     * @param \Enigmatic\CRMBundle\Entity\Contact $contacts
     * @return Agency
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
}
