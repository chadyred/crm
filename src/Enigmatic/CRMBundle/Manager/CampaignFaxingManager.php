<?php

namespace Enigmatic\CRMBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Enigmatic\CRMBundle\Entity\CampaignFaxing;
use Enigmatic\CRMBundle\Entity\User;

class CampaignFaxingManager
{
    protected $em;
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->class = 'EnigmaticCRMBundle:CampaignFaxing';
        $this->em  = $entityManager;
    }

    /**
     * @return CampaignFaxing
     */
    public function create(User $user = null, $state = CampaignFaxing::CAMPAIGN_FAXING_LOCKED) {
        return new CampaignFaxing($user, $state);
    }

    /**
     * @param CampaignFaxing $campaignFaxing
     * @param bool $flush
     * @return CampaignFaxing
     */
    public function save(CampaignFaxing $campaignFaxing, $flush = true) {
        $this->em->persist($campaignFaxing);
        if ($flush)
            $this->em->flush();

        return $campaignFaxing;
    }

    /**
     * @param CampaignFaxing $campaignFaxing
     * @param bool $flush
     * @return CampaignFaxing
     */
    public function remove(CampaignFaxing $campaignFaxing, $flush = true) {
        $this->em->remove($campaignFaxing);
        if ($flush)
            $this->em->flush();

        return $campaignFaxing;
    }

    /**
     * @param int $id
     * @return CampaignFaxing
     */
    public function get($id) {
        return $this->em->getRepository($this->class)->find($id);
    }

    /**
     * @param int $state
     * @return Array
     */
    public function getByState($state = CampaignFaxing::CAMPAIGN_FAXING_WAITING) {
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
