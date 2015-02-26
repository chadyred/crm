<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * CampaignFaxing
 *
 * @ORM\Table(name="crm_campaign_faxing")
 * @ORM\Entity(repositoryClass="Enigmatic\CRMBundle\Repository\CampaignFaxingRepository")
 * @Assert\Callback(methods={"validateDateSended"})
 */
class CampaignFaxing
{
    const CAMPAIGN_FAXING_WAITING = 0;
    const CAMPAIGN_FAXING_SENDED = 1;
    const CAMPAIGN_FAXING_LOCKED = 2;

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
     * @Assert\Length(min="0", max="255")
     */
    private $name;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $owner;

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
     * @var \DateTime
     *
     * @ORM\Column(name="dateSended", type="datetime", nullable=true)
     * @Assert\DateTime()
     */
    private $dateSended;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="smallint")
     * @Assert\NotNull()
     */
    private $state;

    /**
     * @var Contact
     *
     * @ORM\ManyToMany(targetEntity="Enigmatic\CRMBundle\Entity\Contact")
     * @ORM\JoinTable(name="crm_campaign_faxing_contact")
     */
    private $contacts;

    /**
     * @var CampaignFaxingFax
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\CampaignFaxingFax", mappedBy="campaign", cascade="all", orphanRemoval=true)
     */
    private $faxs;

    /**
     * Constructor
     * @param User $owner
     * @param Integer $state
     */
    public function __construct(User $owner = null, $state = CampaignFaxing::CAMPAIGN_FAXING_LOCKED)
    {
        $this->setDateCreated(new \DateTime());
        $this->setDateUpdated(new \DateTime());
        $this->setDateSended(new \DateTime());
        $this->owner = $owner;
        $this->state = $state;
        $this->contacts = new ArrayCollection();
        $this->faxs = new ArrayCollection();
    }

    public function validateDateSended(ExecutionContextInterface $context)
    {
        if ($this->getDateSended() < new \DateTime()) {
            $context->addViolationAt('dateSended', 'enigmatic.crm.campaign_faxing.dateSended.invalid', array(), null);
        }
    }

    /**
     * toString
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
     * @return CampaignFaxing
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return CampaignFaxing
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
     * @return CampaignFaxing
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
     * Set dateSended
     *
     * @param \DateTime $dateSended
     * @return CampaignFaxing
     */
    public function setDateSended($dateSended)
    {
        $this->dateSended = $dateSended;

        return $this;
    }

    /**
     * Get dateSended
     *
     * @return \DateTime 
     */
    public function getDateSended()
    {
        return $this->dateSended;
    }

    /**
     * Set state
     *
     * @param integer $state
     * @return CampaignFaxing
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
     * Set owner
     *
     * @param \Enigmatic\CRMBundle\Entity\User $owner
     * @return CampaignFaxing
     */
    public function setOwner(\Enigmatic\CRMBundle\Entity\User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Enigmatic\CRMBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add contacts
     *
     * @param \Enigmatic\CRMBundle\Entity\Contact $contacts
     * @return CampaignFaxing
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
     * Add faxs
     *
     * @param \Enigmatic\CRMBundle\Entity\CampaignFaxingFax $faxs
     * @return CampaignFaxing
     */
    public function addFax(\Enigmatic\CRMBundle\Entity\CampaignFaxingFax $faxs)
    {
        $this->faxs[] = $faxs;

        return $this;
    }

    /**
     * Remove faxs
     *
     * @param \Enigmatic\CRMBundle\Entity\CampaignFaxingFax $faxs
     */
    public function removeFax(\Enigmatic\CRMBundle\Entity\CampaignFaxingFax $faxs)
    {
        $this->faxs->removeElement($faxs);
    }

    /**
     * Get faxs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFaxs()
    {
        return $this->faxs;
    }
}
