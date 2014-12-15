<?php

namespace Enigmatic\OROMailingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Oro\Bundle\UserBundle\Entity\User;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Campaign
 *
 * @ORM\Table(name="enigmatic_orocrm_campaign")
 * @ORM\Entity(repositoryClass="Enigmatic\OROMailingBundle\Repository\CampaignRepository")
 * @Assert\Callback(methods={"validateDateSended"})
 */
class Campaign
{
    const CAMPAIGN_MAILING_WAITING = 0;
    const CAMPAIGN_MAILING_SENDED = 1;
    const CAMPAIGN_MAILING_LOCKED = 2;


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
     * @var \Oro\Bundle\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=false, name="owner_id")
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
     * @var string
     *
     * @ORM\Column(name="email_subject", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="0", max="255")
     */
    private $emailSubject;

    /**
     * @var string
     *
     * @ORM\Column(name="email_body", type="text", nullable=true)
     */
    private $emailBody;

    /**
     * @var integer
     *
     * @ORM\Column(name="state", type="smallint")
     * @Assert\NotNull()
     */
    private $state;

    /**
     * @var CampaignContact
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\OROMailingBundle\Entity\CampaignContact", mappedBy="campaign", cascade={"all"}, orphanRemoval=true)
     */
    private $contacts;

    /**
     * Constructor
     * @param User $owner
     * @param Integer $state
     */
    public function __construct(User $owner = null, $state = Campaign::CAMPAIGN_MAILING_LOCKED)
    {
        $this->setDateCreated(new \DateTime());
        $this->setDateUpdated(new \DateTime());
        $this->setDateSended(new \DateTime());
        $this->owner = $owner;
        $this->state = $state;
        $this->contacts = new ArrayCollection();
    }

    public function validateDateSended(ExecutionContextInterface $context)
    {
        if ($this->getDateSended() < new \DateTime()) {
            $context->addViolationAt('dateSended', 'This date must be greater than the current time.', array(), null);
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
     * @return Campaign
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
     * @return Campaign
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
     * @return Campaign
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
     * @return Campaign
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
     * Set emailSubject
     *
     * @param string $emailSubject
     * @return Campaign
     */
    public function setEmailSubject($emailSubject)
    {
        $this->emailSubject = $emailSubject;

        return $this;
    }

    /**
     * Get emailSubject
     *
     * @return string 
     */
    public function getEmailSubject()
    {
        return $this->emailSubject;
    }

    /**
     * Set emailBody
     *
     * @param string $emailBody
     * @return Campaign
     */
    public function setEmailBody($emailBody)
    {
        $this->emailBody = $emailBody;

        return $this;
    }

    /**
     * Get emailBody
     *
     * @return string 
     */
    public function getEmailBody()
    {
        return $this->emailBody;
    }

    /**
     * Set owner
     *
     * @param \Oro\Bundle\UserBundle\Entity\User $owner
     * @return Campaign
     */
    public function setOwner(User $owner)
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * Get owner
     *
     * @return \Oro\Bundle\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add contacts
     *
     * @param CampaignContact $contacts
     * @return Campaign
     */
    public function addContact(CampaignContact $contacts)
    {
        $contacts->setCampaign($this);
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param CampaignContact $contacts
     */
    public function removeContact(CampaignContact $contacts)
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
     * Set state
     *
     * @param integer $state
     * @return Campaign
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
}
