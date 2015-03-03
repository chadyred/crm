<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AgencyAccountTurnover
 *
 * @ORM\Table(name="crm_agency_account_turnover")
 * @ORM\Entity
 */
class AgencyAccountTurnover
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
     * @var AgencyAccount
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\AgencyAccount", inversedBy="turnovers")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $agencyAccount;

    /**
     * @var integer
     *
     * @ORM\Column(name="year", type="integer")
     * @Assert\NotNull()
     * @Assert\Range(min="2000")
     */
    private $year;

    /**
     * @var float
     *
     * @ORM\Column(name="turnover", type="float")
     * @Assert\NotNull()
     * @Assert\Range(min="0")
     */
    private $turnover;


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
     * Set year
     *
     * @param integer $year
     * @return AgencyAccountTurnover
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set turnover
     *
     * @param float $turnover
     * @return AgencyAccountTurnover
     */
    public function setTurnover($turnover)
    {
        $this->turnover = str_replace(',', '.', $turnover);

        return $this;
    }

    /**
     * Get turnover
     *
     * @return float
     */
    public function getTurnover()
    {
        return $this->turnover;
    }

    /**
     * Set agencyAccount
     *
     * @param \Enigmatic\CRMBundle\Entity\AgencyAccount $agencyAccount
     * @return AgencyAccountTurnover
     */
    public function setAgencyAccount(\Enigmatic\CRMBundle\Entity\AgencyAccount $agencyAccount)
    {
        $this->agencyAccount = $agencyAccount;

        return $this;
    }

    /**
     * Get agencyAccount
     *
     * @return \Enigmatic\CRMBundle\Entity\AgencyAccount 
     */
    public function getAgencyAccount()
    {
        return $this->agencyAccount;
    }
}
