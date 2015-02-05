<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AccountOwnerEnd
 *
 * @ORM\Table(name="crm_account_owner_end")
 * @ORM\Entity
 */
class AccountOwnerEnd
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
     * @var AccountOwner
     *
     * @ORM\OneToOne(targetEntity="Enigmatic\CRMBundle\Entity\AccountOwner", inversedBy="end")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $accountOwner;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime", nullable=true)
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $dateEnd;


    /**
     * Constructor
     */
    public function __construct(AccountOwner $accountOwner)
    {
        $this->accountOwner = $accountOwner;
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
     * @return AccountOwnerEnd
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
     * Set accountOwner
     *
     * @param \Enigmatic\CRMBundle\Entity\AccountOwner $accountOwner
     * @return AccountOwnerEnd
     */
    public function setAccountOwner(\Enigmatic\CRMBundle\Entity\AccountOwner $accountOwner)
    {
        $this->accountOwner = $accountOwner;

        return $this;
    }

    /**
     * Get accountOwner
     *
     * @return \Enigmatic\CRMBundle\Entity\AccountOwner 
     */
    public function getAccountOwner()
    {
        return $this->accountOwner;
    }
}
