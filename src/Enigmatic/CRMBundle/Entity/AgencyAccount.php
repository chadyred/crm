<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgencyAccount
 *
 * @ORM\Table(name="crm_agency_account")
 * @ORM\Entity
 */
class AgencyAccount
{
    const TOP_100 = 1;
    const TOP_150 = 2;
    const OTHER = 3;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Agency
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\Agency", inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $agency;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\Account", inversedBy="agencies")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $account;

    /**
     * @var integer
     *
     * @ORM\Column(name="potential", type="smallint")
     * @Assert\NotNull()
     * @Assert\Range(min="1", max="3")
     */
    private $potential;

    /**
     * @var AgencyAccountTurnover
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CRMBundle\Entity\AgencyAccountTurnover", mappedBy="agencyAccount")
     */
    private $turnovers;

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
     * Constructor
     */
    public function __construct($potential = self::OTHER)
    {
        $this->potential = $potential;
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();
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
     * Set potential
     *
     * @param integer $potential
     * @return AgencyAccount
     */
    public function setPotential($potential)
    {
        $this->potential = $potential;

        return $this;
    }

    /**
     * Get potential
     *
     * @return integer 
     */
    public function getPotential()
    {
        return $this->potential;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return AgencyAccount
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
     * @return AgencyAccount
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
     * Set agency
     *
     * @param \Enigmatic\CRMBundle\Entity\Agency $agency
     * @return AgencyAccount
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
     * Set account
     *
     * @param \Enigmatic\CRMBundle\Entity\Account $account
     * @return AgencyAccount
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
     * Add turnovers
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyAccountTurnover $turnovers
     * @return AgencyAccount
     */
    public function addTurnover(\Enigmatic\CRMBundle\Entity\AgencyAccountTurnover $turnovers)
    {
        $this->turnovers[] = $turnovers;

        return $this;
    }

    /**
     * Remove turnovers
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyAccountTurnover $turnovers
     */
    public function removeTurnover(\Enigmatic\CRMBundle\Entity\AgencyAccountTurnover $turnovers)
    {
        $this->turnovers->removeElement($turnovers);
    }

    /**
     * Get turnovers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTurnovers()
    {
        return $this->turnovers;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return AgencyAccount
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
}
