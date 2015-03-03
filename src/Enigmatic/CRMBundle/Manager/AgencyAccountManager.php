<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\Agency;
use Enigmatic\CRMBundle\Entity\AgencyAccount;

class AgencyAccountManager
{
    protected $em;
    protected $class;
    protected $userManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, UserManager $userManager) {
        $this->class = 'EnigmaticCRMBundle:AgencyAccount';
        $this->em  = $entityManager;
        $this->userManager  = $userManager;
    }

    /**
     * @param Account $account
     * @param Agency $agency
     * @return AgencyAccount
     */
    public function create(Account $account = null, Agency $agency = null) {
        return new AgencyAccount($account, $agency);
    }

    /**
     * @param AgencyAccount $agency_account
     * @param bool $flush
     * @return AgencyAccount
     */
    public function save(AgencyAccount $agency_account, $flush = true) {
        $agency_account->setDateUpdated(new \DateTime());
        $this->em->persist($agency_account);
        if ($flush)
            $this->em->flush();

        return $agency_account;
    }

    /**
     * @param AgencyAccount $agency_account
     * @param bool $flush
     * @return AgencyAccount
     */
    public function remove(AgencyAccount $agency_account, $flush = true) {
        $this->em->remove($agency_account);
        if ($flush)
            $this->em->flush();

        return $agency_account;
    }

    /**
     * @param int $id
     * @return AgencyAccount
     */
    public function get($id) {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * @param Account $account
     * @return AgencyAccount
     */
    public function getOneByAccount(Account $account) {
        return $this->em->getRepository($this->class)->findOneByAccountAndAgency($account, $this->userManager->getCurrent()?$this->userManager->getCurrent()->getAgency():null);
    }

    /**
     * @return Array
     */
    public function getAll() {
        return $this->em->getRepository($this->class)->findAll();
    }

}
