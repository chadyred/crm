<?php

namespace Enigmatic\CRMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping\OrderBy;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Activity
 *
 * @ORM\Table(name="crm_activity")
 * @ORM\Entity(repositoryClass="Enigmatic\CRMBundle\Repository\ActivityRepository")
 * @Assert\Callback(methods={"isValid"})
 */
class Activity
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
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\User", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $user;

    /**
     * @var Account
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\Account", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $account;

    /**
     * @var ActivityType
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CRMBundle\Entity\ActivityType", inversedBy="activities")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     * @OrderBy({"title" = "ASC"})
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateStart", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $dateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnd", type="datetime")
     * @Assert\DateTime()
     * @Assert\NotNull()
     */
    private $dateEnd;

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
     * @var Activity
     *
     * @ORM\OneToOne(targetEntity="Enigmatic\CRMBundle\Entity\Activity", inversedBy="replannedBy", cascade={"persist", "detach", "merge"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $replanned;

    /**
     * @var Activity
     *
     * @ORM\OneToOne(targetEntity="Enigmatic\CRMBundle\Entity\Activity", mappedBy="replanned", cascade={"persist", "detach", "merge"})
     */
    private $replannedBy;


    /**
     * Constructor
     */
    public function __construct(Account $account = null, Activity $activity = null, User $user = null, ActivityType $type = null)
    {
        $this->account = $account;
        $this->user = $user;
        $this->type = $type;

        $this->dateStart = new \DateTime();
        $this->dateCreated = new \DateTime();
        $this->dateUpdated = new \DateTime();

        if ($activity) {
            $this->account = $activity->getAccount();
            $this->user = $activity->getUser();
            $this->setReplannedBy($activity);
            $this->type = $activity->getType();
            $this->comment = $activity->getComment();
            $this->dateStart = $activity->getDateStart();
        }
    }

    public function isValid(ExecutionContextInterface $context)
    {
        if ($this->getDateEnd() <= $this->getDateStart()) {
            $context->addViolation('Date de fin incohérente');
        }
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
     * Set comment
     *
     * @param string $comment
     * @return Activity
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     * @return Activity
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
     * @return Activity
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
     * Set user
     *
     * @param \Enigmatic\CRMBundle\Entity\User $user
     * @return Activity
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
     * @return Activity
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
     * Set dateStart
     *
     * @param \DateTime $dateStart
     * @return Activity
     */
    public function setDateStart($dateStart)
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    /**
     * Get dateStart
     *
     * @return \DateTime 
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * Set dateEnd
     *
     * @param \DateTime $dateEnd
     * @return Activity
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
     * Set type
     *
     * @param \Enigmatic\CRMBundle\Entity\ActivityType $type
     * @return Activity
     */
    public function setType(\Enigmatic\CRMBundle\Entity\ActivityType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Enigmatic\CRMBundle\Entity\ActivityType 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set replanned
     *
     * @param \Enigmatic\CRMBundle\Entity\Activity $replanned
     * @return Activity
     */
    public function setReplanned(\Enigmatic\CRMBundle\Entity\Activity $replanned = null)
    {
        $this->replanned = $replanned;

        return $this;
    }

    /**
     * Get replanned
     *
     * @return \Enigmatic\CRMBundle\Entity\Activity 
     */
    public function getReplanned()
    {
        return $this->replanned;
    }

    /**
     * Set replannedBy
     *
     * @param \Enigmatic\CRMBundle\Entity\Activity $replannedBy
     * @return Activity
     */
    public function setReplannedBy(\Enigmatic\CRMBundle\Entity\Activity $replannedBy = null)
    {
        if ($replannedBy)
            $replannedBy->setReplanned($this);
        elseif ($this->replannedBy)
            $this->replannedBy->setReplanned(null);
        $this->replannedBy = $replannedBy;

        return $this;
    }

    /**
     * Get replannedBy
     *
     * @return \Enigmatic\CRMBundle\Entity\Activity 
     */
    public function getReplannedBy()
    {
        return $this->replannedBy;
    }
}
