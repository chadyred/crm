<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CRMBundle\Entity\Account;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Enigmatic\CRMBundle\Entity\AccountOwner;
use Enigmatic\CRMBundle\Entity\AgencyAccount;

class AccountManager
{
    protected $em;
    protected $class;
    protected $userManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, UserManager $userManager) {
        $this->class = 'EnigmaticCRMBundle:Account';
        $this->em  = $entityManager;
        $this->userManager  = $userManager;
    }

    /**
     * @param Integer $state
     * @return Account
     */
    public function create($state = Account::VALID) {
        $account = new Account($state);
        if ($this->userManager->getCurrent()) {
            if ($this->userManager->getCurrent()->hasRole('ROLE_CA') && !$this->userManager->getCurrent()->hasRole('ROLE_RS')) {
                $account->addAgency(new AgencyAccount($account, $this->userManager->getCurrent()->getAgency()));
                if (!$this->userManager->getCurrent()->hasRole('ROLE_RCA'))
                    $account->addOwner(new AccountOwner($account, $this->userManager->getCurrent()));
            }
        }
        return $account;
    }

    /**
     * @param Account $account
     * @param bool $flush
     * @return Account
     */
    public function save(Account $account, $flush = true) {
        $account->setDateUpdated(new \DateTime());
        $this->em->persist($account);
        if ($flush)
            $this->em->flush();

        return $account;
    }

    /**
     * @param Account $account
     * @param bool $flush
     * @return Account
     */
    public function remove(Account $account, $flush = true) {
        $this->em->remove($account);
        if ($flush)
            $this->em->flush();

        return $account;
    }

    /**
     * @param int $id
     * @return Account
     */
    public function get($id) {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * @param int $id
     * @param int $city
     * @return Account
     */
    public function getByNameAndCity($name, $city) {
        return $this->em->getRepository($this->class)->findByNameAndCity($name, $city);
    }

    /**
     * @return Array
     */
    public function getAll() {
        return $this->em->getRepository($this->class)->findAll();
    }

    /**
     * @param int $page
     * @param array $params
     * @return Paginator
     */
    public function getList($page = 0, $listPageLimit = null, $params = array(), $states = array(Account::VALID)) {
        return $this->em->getRepository($this->class)->getList($page, $listPageLimit, $params, $states);
    }

}
