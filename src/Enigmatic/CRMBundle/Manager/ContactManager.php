<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\Contact;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class ContactManager
{
    protected $em;
    protected $class;
    protected $authorizationChecker;
    protected $userManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, AuthorizationChecker $authorizationChecker, UserManager $userManager) {
        $this->class = 'EnigmaticCRMBundle:Contact';
        $this->em  = $entityManager;
        $this->authorizationChecker  = $authorizationChecker;
        $this->userManager  = $userManager;
    }

    /**
     * @param Account $account
     * @return Contact
     */
    public function create(Account $account = null) {
        if (!$this->authorizationChecker->isGranted('ROLE_RS'))
            $contact = new Contact($account, $this->userManager->getCurrent()->getAgency());
        else
            $contact = new Contact($account);

        return $contact;
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
