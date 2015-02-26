<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contact
 *
 * @ORM\Table(name="crm_contact")
 * @ORM\Entity(repositoryClass="Enigmatic\CRMBundle\Repository\ContactRepository")
 */
class Contact
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
     * @ORM\Column(name="firstname", type="string", length=45, nullable=true)
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
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     * @Assert\Email()
     * @Assert\Length(max="255")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="function", type="string", length=255, nullable=true)
     * @Assert\Length(max="255")
     */
    private $function;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     * @Assert\Date()
     */
    private $birthday;

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
     * @ORM\JoinColumn(nullable=true)
     */
    private $city;

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
     * @var ContactPhone
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\ContactPhone", mappedBy="contact", cascade="all", orphanRemoval=true)
     */
    private $phones;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\Account", inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $account;

    /**
     * @var Agency
     *
     * @ORM\ManyToMany(targetEntity="Enigmatic\CRMBundle\Entity\Agency", mappedBy="contacts")
     */
    private $agencies;



    /**
     * Constructor
     */
    public function __construct(Account $account = null)
    {
        $this->account = $account;
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
    }

    /**
     * toString
     */
    public function __toString()
    {
        return $this->getFirstname().' '.$this->getName().' ('.$this->getAccount()->getName().')';
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
     * @return Contact
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
     * @return Contact
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
     * Set email
     *
     * @param string $email
     * @return Contact
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
     * Set birthday
     *
     * @param \DateTime $birthday
     * @return Contact
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday
     *
     * @return \DateTime 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Contact
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
     * @return Contact
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
     * Set description
     *
     * @param string $description
     * @return Contact
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
     * @return Contact
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
     * @return Contact
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
     * @return Contact
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
     * Add phones
     *
     * @param \Enigmatic\CRMBundle\Entity\ContactPhone $phones
     * @return Contact
     */
    public function addPhone(\Enigmatic\CRMBundle\Entity\ContactPhone $phones)
    {
        $this->phones[] = $phones;

        return $this;
    }

    /**
     * Remove phones
     *
     * @param \Enigmatic\CRMBundle\Entity\ContactPhone $phones
     */
    public function removePhone(\Enigmatic\CRMBundle\Entity\ContactPhone $phones)
    {
        $this->phones->removeElement($phones);
    }

    /**
     * Get phones
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * Get fax
     *
     * @return string | null
     */
    public function getFax()
    {
        foreach ($this->getPhones() as $phone) {
            if ($phone->getType() == ContactPhone::FAX)
                return $phone->getNumero();
        }

        return $this->getAccount()->getFax();
    }

    /**
     * Set account
     *
     * @param \Enigmatic\CRMBundle\Entity\Account $account
     * @return Contact
     */
    public function setAccount(\Enigmatic\CRMBundle\Entity\Account $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Enigmatic\CRMBundle\Entity\Account 
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Add agencies
     *
     * @param \Enigmatic\CRMBundle\Entity\Agency $agencies
     * @return Contact
     */
    public function addAgency(\Enigmatic\CRMBundle\Entity\Agency $agencies)
    {
        $this->agencies[] = $agencies;

        return $this;
    }

    /**
     * Remove agencies
     *
     * @param \Enigmatic\CRMBundle\Entity\Agency $agencies
     */
    public function removeAgency(\Enigmatic\CRMBundle\Entity\Agency $agencies)
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
     * Set function
     *
     * @param string $function
     * @return Contact
     */
    public function setFunction($function)
    {
        $this->function = $function;

        return $this;
    }

    /**
     * Get function
     *
     * @return string 
     */
    public function getFunction()
    {
        return $this->function;
    }
}
