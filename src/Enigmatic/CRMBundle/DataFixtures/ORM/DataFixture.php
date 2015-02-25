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
        $em->persist(new ActivityType('Visite sauvage', ActivityType::RDV));
        $em->persist(new ActivityType('Visite de courtoisie', ActivityType::RDV));
        $em->persist(new ActivityType('Dépôt de goodie', ActivityType::RDV));
        $em->persist(new ActivityType('Rendez vous DA', ActivityType::RDV));
        $em->persist(new ActivityType('Visite Recouvrement', ActivityType::RDV));
        $em->persist(new ActivityType('RDV bilan/suivi', ActivityType::RDV));
        $em->persist(new ActivityType('RDV Litige', ActivityType::RDV));
        $em->persist(new ActivityType('Qualification de fiche', ActivityType::CALL));
        $em->persist(new ActivityType('Prise de rendez vous', ActivityType::CALL));
        $em->persist(new ActivityType('Contrôle de référence', ActivityType::CALL));
        $em->persist(new ActivityType('Relance', ActivityType::CALL));
        $em->persist(new ActivityType('Date de l\'appel téléphonique', ActivityType::CALL));
        $em->persist(new ActivityType('Suivi', ActivityType::CALL));
        $em->persist(new ActivityType('Message répondeur', ActivityType::CALL));
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