<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Enigmatic\CRMBundle\Entity\ActivityType;

class ActivityTypeManager
{
    protected $em;
    protected $userManager;
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->class = 'EnigmaticCRMBundle:ActivityType';
        $this->em  = $entityManager;
    }

    /**
     * @param string $title
     * @param integer $type
     * @return ActivityType
     */
    public function create($title = '', $type = null) {
        return new ActivityType($title, $type);
    }

    /**
     * @param ActivityType $activityType
     * @param bool $flush
     * @return ActivityType
     */
    public function save(ActivityType $activityType, $flush = true) {
        $this->em->persist($activityType);
        if ($flush)
            $this->em->flush();

        return $activityType;
    }

    /**
     * @param ActivityType $activityType
     * @param bool $flush
     * @return ActivityType
     */
    public function remove(ActivityType $activityType, $flush = true) {
        $this->em->remove($activityType);
        if ($flush)
            $this->em->flush();

        return $activityType;
    }

    /**
     * @param int $id
     * @return ActivityType
     */
    public function get($id) {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * @param string $name
     * @return ActivityType
     */
    public function getByName($name) {
        return $this->em->getRepository($this->class)->findOneByName($name);
    }

    /**
     * @return Array
     */
    public function getAll() {
        return $this->em->getRepository($this->class)->findAll();
    }
}
