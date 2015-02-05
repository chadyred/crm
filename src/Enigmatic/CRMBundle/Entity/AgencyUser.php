<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgencyUser
 *
 * @ORM\Table(name="crm_agency_user")
 * @ORM\Entity
 */
class AgencyUser
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\User", inversedBy="agencies")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $user;

    /**
     * @var Agency
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\Agency", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $agency;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $dateCreated;

    /**
     * @var AgencyUserEnd
     *
     * @ORM\OneToOne(targetEntity="Enigmatic\CRMBundle\Entity\AgencyUserEnd", mappedBy="agencyUser")
     */
    private $end;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->end = new \DateTime();
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return AgencyUser
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
     * Set user
     *
     * @param \Enigmatic\CRMBundle\Entity\User $user
     * @return AgencyUser
     */
    public function setUser(\Enigmatic\CRMBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Enigmatic\CRMBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set agency
     *
     * @param \Enigmatic\CRMBundle\Entity\Agency $agency
     * @return AgencyUser
     */
    public function setAgency(\Enigmatic\CRMBundle\Entity\Agency $agency)
    {
        $this->agency = $agency;

        return $this;
    }

    /**
     * Get agency
     *
     * @return \Enigmatic\CRMBundle\Entity\Agency 
     */
    public function getAgency()
    {
        return $this->agency;
    }

    /**
     * Set end
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyUserEnd $end
     * @return AgencyUser
     */
    public function setEnd(\Enigmatic\CRMBundle\Entity\AgencyUserEnd $end = null)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \Enigmatic\CRMBundle\Entity\AgencyUserEnd 
     */
    public function getEnd()
    {
        return $this->end;
    }
}
