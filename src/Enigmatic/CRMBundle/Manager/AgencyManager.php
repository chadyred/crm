<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CRMBundle\Entity\Agency;
use Doctrine\ORM\Tools\Pagination\Paginator;

class AgencyManager
{
    protected $em;
    protected $class;
    protected $userManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager, UserManager $userManager) {
        $this->class = 'EnigmaticCRMBundle:Agency';
        $this->em  = $entityManager;
        $this->userManager  = $userManager;
    }

    /**
     * @return Agency
     */
    public function create() {
        return new Agency();
    }

    /**
     * @param Agency $agency
     * @param bool $flush
     * @return Agency
     */
    public function save(Agency $agency, $flush = true) {
        $this->em->persist($agency);
        if ($flush)
            $this->em->flush();

        return $agency;
    }

    /**
     * @param Agency $agency
     * @param bool $flush
     * @return Agency
     */
    public function remove(Agency $agency, $flush = true) {

        foreach ($this->userManager->getAll() as $user) {
            if ($user->getAgency() == $agency)
                $this->userManager->remove($user);
        }

        $this->em->remove($agency);
        if ($flush)
            $this->em->flush();

        return $agency;
    }

    /**
     * @param int $id
     * @return Agency
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
