<?php

namespace EnigmaticCRMBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Enigmatic\CRMBundle\Entity\ActivityType;
use UserBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;


class DataFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $em)
    {
        $em->persist(new ActivityType('rdv_visite_sauvage', 'Visite sauvage', ActivityType::RDV));
        $em->persist(new ActivityType('rdv_visite_courtoisie', 'Visite de courtoisie', ActivityType::RDV));
        $em->persist(new ActivityType('rdv_depot_goodies', 'Dépôt de goodie', ActivityType::RDV));
        $em->persist(new ActivityType('rdv_rdv_da', 'Rendez vous DA', ActivityType::RDV));
        $em->persist(new ActivityType('rdv_visite_recouvrement', 'Visite Recouvrement', ActivityType::RDV));
        $em->persist(new ActivityType('rdv_bilan_suivi', 'RDV bilan/suivi', ActivityType::RDV));
        $em->persist(new ActivityType('rdv_rdv_litige', 'RDV Litige', ActivityType::RDV));
        $em->persist(new ActivityType('call_qualification_fiche', 'Qualification de fiche', ActivityType::CALL));
        $em->persist(new ActivityType('call_prise_rdv', 'Prise de rendez vous', ActivityType::CALL));
        $em->persist(new ActivityType('call_controle_ref', 'Contrôle de référence', ActivityType::CALL));
        $em->persist(new ActivityType('call_relance', 'Relance', ActivityType::CALL));
        $em->persist(new ActivityType('call_suivi', 'Suivi', ActivityType::CALL));
        $em->persist(new ActivityType('call_repondeur', 'Message répondeur', ActivityType::CALL));
        $em->persist(new ActivityType('campaign_mailing', 'Envois d\'un mailing', ActivityType::CAMPAIGN));
        $em->persist(new ActivityType('campaign_faxing', 'Envois d\'un faxing', ActivityType::CAMPAIGN));
        $em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }

}