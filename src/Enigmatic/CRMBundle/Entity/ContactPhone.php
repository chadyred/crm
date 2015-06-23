<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ContactPhone
 *
 * @ORM\Table(name="crm_contact_phone")
 * @ORM\Entity
 */
class ContactPhone
{
    const WORK = 1;
    const HOME = 2;
    const MOBILE = 3;
    const FAX = 4;
    const OTHER = 5;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Contact
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\Contact", inversedBy="phones")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $contact;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=12)
     * @Assert\NotNull()
     * @Assert\Regex(pattern="/^([+]{1}[0-9]{1})?[0-9]{10}$/", message="phone.invalid_format")
     */
    private $phone;

    /**
     * @var integer
     *
     * @ORM\Column(name="type", type="smallint")
     * @Assert\NotNull()
     * @Assert\Range(min="1", max="5")
     */
    private $type;


    /**
     * Constructor
     */
    public function __construct($type = null)
    {
        $this->type = $type;
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
     * Set phone
     *
     * @param string $phone
     * @return ContactPhone
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
     * Set type
     *
     * @param integer $type
     * @return ContactPhone
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
     * Set contact
     *
     * @param \Enigmatic\CRMBundle\Entity\Contact $contact
     * @return ContactPhone
     */
    public function setContact(\Enigmatic\CRMBundle\Entity\Contact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \Enigmatic\CRMBundle\Entity\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }
}
