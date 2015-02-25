<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * AccountOwner
 *
 * @ORM\Table(name="crm_account_owner")
 * @ORM\Entity
 */
class AccountOwner
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
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\User", inversedBy="assignedAccount")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $user;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\Account", inversedBy="owners")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $account;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $dateCreated;

    /**
     * @var AccountOwnerEnd
     *
     * @ORM\OneToOne(targetEntity="Enigmatic\CRMBundle\Entity\AccountOwnerEnd", mappedBy="accountOwner", cascade="all")
     */
    private $end;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dateCreated = new \DateTime();
        $this->end = null;
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
     * @return AccountOwner
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
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return AccountOwner
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
     * Set user
     *
     * @param \Enigmatic\CRMBundle\Entity\User $user
     * @return AccountOwner
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
     * Set account
     *
     * @param \Enigmatic\CRMBundle\Entity\Account $account
     * @return AccountOwner
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
     * Set end
     *
     * @param \Enigmatic\CRMBundle\Entity\AccountOwnerEnd $end
     * @return AccountOwner
     */
    public function setEnd(\Enigmatic\CRMBundle\Entity\AccountOwnerEnd $end = null)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \Enigmatic\CRMBundle\Entity\AccountOwnerEnd 
     */
    public function getEnd()
    {
        return $this->end;
    }
}
