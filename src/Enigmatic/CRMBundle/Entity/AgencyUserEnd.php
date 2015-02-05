<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgencyUserEnd
 *
 * @ORM\Table(name="crm_agency_user_end")
 * @ORM\Entity
 */
class AgencyUserEnd
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
     * @var AgencyUser
     *
     * @ORM\OneToOne(targetEntity="Enigmatic\CRMBundle\Entity\AgencyUser", inversedBy="end")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $agencyUser;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $dateEnd;


    /**
     * Constructor
     */
    public function __construct(AgencyUser $agencyUser)
    {
        $this->agencyUser = $agencyUser;
        $this->dateEnd = new \DateTime();
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
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return AgencyUserEnd
     */
    public function setDateEnd($dateEnd)
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    /**
     * Get dateEnd
     *
     * @return \DateTime 
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * Set agencyUser
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyUser $agencyUser
     * @return AgencyUserEnd
     */
    public function setAgencyUser(\Enigmatic\CRMBundle\Entity\AgencyUser $agencyUser)
    {
        $this->agencyUser = $agencyUser;

        return $this;
    }

    /**
     * Get agencyUser
     *
     * @return \Enigmatic\CRMBundle\Entity\AgencyUser 
     */
    public function getAgencyUser()
    {
        return $this->agencyUser;
    }
}
