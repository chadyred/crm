<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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
        $userManager = $this->container->get('fos_user.user_manager');

        $super_admin = $userManager->createUser();
        $super_admin->setEmail($this->container->getParameter('email.super_admin'));
        $super_admin->setUsername(26071991);
        $super_admin->addRole('ROLE_SUPER_ADMIN');
        $super_admin->setPlainPassword('azert');
        $super_admin->setEnabled(true);
        $super_admin->setDateCreated(new \DateTime());
        $userManager->updateUser($super_admin);
        $em->flush();

        $admin = $userManager->createUser();
        $admin->setEmail($this->container->getParameter('email.admin'));
        $admin->setUsername(58658545);
        $admin->addRole('ROLE_ADMIN');
        $admin->setPlainPassword('azert');
        $admin->setEnabled(true);
        $admin->setDateCreated(new \DateTime());
        $userManager->updateUser($admin);
        $em->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }

}