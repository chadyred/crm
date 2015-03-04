<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\Activity;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Enigmatic\CRMBundle\Entity\User;

class ActivityManager
{
    protected $em;
    protected $userManager;
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, UserManager $userManager) {
        $this->class = 'EnigmaticCRMBundle:Activity';
        $this->em  = $entityManager;
        $this->userManager  = $userManager;
    }

    /**
     * @param Account $account
     * @param integer $type
     * @return Activity
     */
    public function create(Account $account = null, Activity $activity = null, User $user = null, $type = null) {
        return new Activity($account, $activity, $user?$user:$this->userManager->getCurrent(), $type);
    }

    /**
     * @param Activity $activity
     * @param bool $flush
     * @return Activity
     */
    public function save(Activity $activity, $flush = true) {
        $this->em->persist($activity);
        if ($flush)
            $this->em->flush();

        return $activity;
    }

    /**
     * @param Activity $activity
     * @param bool $flush
     * @return Activity
     */
    public function remove(Activity $activity, $flush = true) {
        $activity->setReplanned(null);
        $activity->setReplannedBy(null);

        $this->em->remove($activity);
        if ($flush)
            $this->em->flush();

        return $activity;
    }

    /**
     * @param int $id
     * @return Activity
     */
    public function get($id) {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * @return Array
     */
    public function getAll() {
        return $this->em->getRepository($this->class)->findAll();
    }

    /**
     * @return Array
     */
    public function getAllByDate(\DateTime $from = null, \DateTime $to = null, $params = array(), $replanned = false) {
        return $this->em->getRepository($this->class)->findAllByDate($from, $to, $params, $replanned);
    }

    /**
     * @param int $page
     * @param array $params
     * @param bool $replanned
     * @return Paginator
     */
    public function getList($page = 0, $listPageLimit = null, $params = array(), $replanned = false) {
        return $this->em->getRepository($this->class)->getList($page, $listPageLimit, $params, $replanned);
    }

}
