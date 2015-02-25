<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CRMBundle\Entity\Account;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AccountManager
{
    protected $em;
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->class = 'EnigmaticCRMBundle:Account';
        $this->em  = $entityManager;
    }

    /**
     * @param Integer $state
     * @return Account
     */
    public function create($state = Account::VALID) {
        return new Account($state);
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
