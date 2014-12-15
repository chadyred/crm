<?php

namespace Enigmatic\OROMailingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use OroCRM\Bundle\ContactBundle\Entity\Contact;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * CampaignContact
 *
 * @ORM\Table(name="enigmatic_orocrm_campaign_contact", uniqueConstraints={@UniqueConstraint(name="campaign_contact", columns={"campaign_id", "contact_id"})}))
 * @ORM\Entity
 * @UniqueEntity(fields={"campaign", "contact"}, message="This contact already joined to this campaign.")
 */
class CampaignContact
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
     * @var \Enigmatic\OROMailingBundle\Entity\Campaign
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\OROMailingBundle\Entity\Campaign", inversedBy="contacts")
     * @ORM\JoinColumn(nullable=false, name="campaign_id")
     * @Assert\NotNull()
     */
    private $campaign;

    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="OroCRM\Bundle\ContactBundle\Entity\Contact")
     * @ORM\JoinColumn(nullable=false, name="contact_id")
     * @Assert\NotNull()
     */
    private $contact;


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
     * Set campaign
     *
     * @param \Enigmatic\OROMailingBundle\Entity\Campaign $campaign
     * @return CampaignContact
     */
    public function setCampaign(Campaign $campaign)
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * Get campaign
     *
     * @return \Enigmatic\OROMailingBundle\Entity\Campaign 
     */
    public function getCampaign()
    {
        return $this->campaign;
    }
    

    /**
     * Set contact
     *
     * @param Contact $contact
     * @return CampaignContact
     */
    public function setContact(Contact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return Contact
     */
    public function getContact()
    {
        return $this->contact;
    }
}
