<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\AccountOwner;
use Enigmatic\CRMBundle\Entity\User;

class AccountOwnerManager
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
     * @param Account $account
     * @param User $user
     * @return AccountOwner
     */
    public function create(Account $account = null, User $user = null) {
        return new AccountOwner($account, $user);
    }

    /**
     * @param AccountOwner $account_owner
     * @param bool $flush
     * @return AccountOwner
     */
    public function save(AccountOwner $account_owner, $flush = true) {
        $this->em->persist($account_owner);
        if ($flush)
            $this->em->flush();

        return $account_owner;
    }

    /**
     * @param AccountOwner $account_owner
     * @param bool $flush
     * @return AccountOwner
     */
    public function remove(AccountOwner $account_owner, $flush = true) {
        $this->em->remove($account_owner);
        if ($flush)
            $this->em->flush();

        return $account_owner;
    }

    /**
     * @param int $id
     * @return AccountOwner
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

}
