<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Enigmatic\CRMBundle\Entity\CampaignMailing;
use Enigmatic\CRMBundle\Entity\User;

class CampaignMailingManager
{
    protected $em;
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->class = 'EnigmaticCRMBundle:CampaignMailing';
        $this->em  = $entityManager;
    }

    /**
     * @return CampaignMailing
     */
    public function create(User $user = null, $state = CampaignMailing::CAMPAIGN_MAILING_LOCKED) {
        return new CampaignMailing($user, $state);
    }

    /**
     * @param CampaignMailing $campaignMailing
     * @param bool $flush
     * @return CampaignMailing
     */
    public function save(CampaignMailing $campaignMailing, $flush = true) {
        $this->em->persist($campaignMailing);
        if ($flush)
            $this->em->flush();

        return $campaignMailing;
    }

    /**
     * @param CampaignMailing $campaignMailing
     * @param bool $flush
     * @return CampaignMailing
     */
    public function remove(CampaignMailing $campaignMailing, $flush = true) {
        $this->em->remove($campaignMailing);
        if ($flush)
            $this->em->flush();

        return $campaignMailing;
    }

    /**
     * @param int $id
     * @return CampaignMailing
     */
    public function get($id) {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * @param int $state
     * @return Array
     */
    public function getByState($state = CampaignMailing::CAMPAIGN_MAILING_WAITING) {
        return $this->em->getRepository($this->class)->findByState($state);
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
