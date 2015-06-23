<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CRMBundle\Entity\User;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class UserManager
{
    protected $em;
    protected $tokenStorage;
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, TokenStorage $tokenStorage) {
        $this->class = 'EnigmaticCRMBundle:User';
        $this->em  = $entityManager;
        $this->tokenStorage  = $tokenStorage;
    }

    /**
     * @param \UserBundle\Entity\User $user
     * @return User
     */
    public function create(\UserBundle\Entity\User $user = null) {
        return new User($user);
    }

    /**
     * @param User $user
     * @param bool $flush
     * @return User
     */
    public function save(User $user, $flush = true) {
        $this->em->persist($user);
        if ($flush)
            $this->em->flush();

        return $user;
    }

    /**
     * @param User $user
     * @param bool $flush
     * @return User
     */
    public function remove(User $user, $flush = true) {
        $this->em->remove($user);
        if ($flush)
            $this->em->flush();

        return $user;
    }

    /**
     * @param int $id
     * @return User
     */
    public function get($id) {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * @return User
     */
    public function getCurrent() {
        if ($this->tokenStorage->getToken())
            return $this->em->getRepository($this->class)->findOneByUser($this->tokenStorage->getToken()->getUser());
        else
            return null;
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
