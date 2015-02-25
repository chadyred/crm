<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\Contact;
use Doctrine\ORM\Tools\Pagination\Paginator;

class ContactManager
{
    protected $em;
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->class = 'EnigmaticCRMBundle:Contact';
        $this->em  = $entityManager;
    }

    /**
     * @param Account $account
     * @return Contact
     */
    public function create(Account $account = null) {
        return new Contact($account);
    }

    /**
     * @param Contact $contact
     * @param bool $flush
     * @return Contact
     */
    public function save(Contact $contact, $flush = true) {
        $this->em->persist($contact);
        if ($flush)
            $this->em->flush();

        return $contact;
    }

    /**
     * @param Contact $contact
     * @param bool $flush
     * @return Contact
     */
    public function remove(Contact $contact, $flush = true) {
        $this->em->remove($contact);
        if ($flush)
            $this->em->flush();

        return $contact;
    }

    /**
     * @param int $id
     * @return Contact
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
    public function getList($page = 0, $listPageLimit = null, $params = array()) {
        return $this->em->getRepository($this->class)->getList($page, $listPageLimit, $params);
    }

}
