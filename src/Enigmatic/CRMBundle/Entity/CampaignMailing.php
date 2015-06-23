<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * CampaignMailing
 *
 * @ORM\Table(name="crm_campaign_mailling")
 * @ORM\Entity(repositoryClass="Enigmatic\CRMBundle\Repository\CampaignMailingRepository")
 * @Assert\Callback(methods={"validateDateSended"})
 */
class CampaignMailing
{
    const CAMPAIGN_MAILING_WAITING = 2;
    const CAMPAIGN_MAILING_SENDED = 1;
    const CAMPAIGN_MAILING_LOCKED = 3;


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
     * @Assert\Range(min=1, max=3)
     */
    private $state;

    /**
     * @var Contact
     *
     * @ORM\ManyToMany(targetEntity="Enigmatic\CRMBundle\Entity\Contact")
     * @ORM\JoinTable(name="crm_campaign_mailling_contact")
     */
    private $contacts;

    /**
     * @var CampaignMailingFile
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\CampaignMailingFile", mappedBy="campaign", cascade="all", orphanRemoval=true)
     */
    private $files;

    /**
     * Constructor
     * @param User $owner
     * @param Integer $state
     */
    public function __construct(User $owner = null, $state = CampaignMailing::CAMPAIGN_MAILING_LOCKED)
    {
        $this->setDateCreated(new \DateTime());
        $this->setDateUpdated(new \DateTime());
        $this->setDateSended(new \DateTime());
        $this->owner = $owner;
        $this->state = $state;
        $this->contacts = new ArrayCollection();
        $this->files = new ArrayCollection();
    }

    public function validateDateSended(ExecutionContextInterface $context)
    {
        if ($this->getDateSended() < new \DateTime()) {
            $context->addViolationAt('dateSended', 'enigmatic.crm.campaign_mailing.dateSended.invalid', array(), null);
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
     * @return CampaignMailing
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
     * @return CampaignMailing
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
     * @return CampaignMailing
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
     * @return CampaignMailing
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
     * @return CampaignMailing
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
     * @return CampaignMailing
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
     * Set state
     *
     * @param integer $state
     * @return CampaignMailing
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
     * @return CampaignMailing
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
     * @return CampaignMailing
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
     * Add file
     *
     * @param \Enigmatic\CRMBundle\Entity\CampaignMailingFile $file
     * @return CampaignMailing
     */
    public function addFile(\Enigmatic\CRMBundle\Entity\CampaignMailingFile $file)
    {
        $this->file[] = $file;

        return $this;
    }
    

    /**
     * Remove files
     *
     * @param \Enigmatic\CRMBundle\Entity\CampaignMailingFile $files
     */
    public function removeFile(\Enigmatic\CRMBundle\Entity\CampaignMailingFile $files)
    {
        $this->files->removeElement($files);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiles()
    {
        return $this->files;
    }
}
