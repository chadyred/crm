<?php

namespace Enigmatic\CRMBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Enigmatic\CRMBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UserListener
{
    protected $container;
    protected $password;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container = $container;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof User) {
            $user = $args->getEntity();
            if ($user->getPlainPassword())
                $this->container->get('fos_user.user_manager')->updateUser($user->getUser(), false);

            if (!$user->getUser()->getId()) {
                $this->password = $this->container->get('enigmatic.token_generator')->generateToken(8);
                $user->setPlainPassword($this->password);
                $user->addRole('ROLE_CA');
                $user->setEnabled(true);
                $this->container->get('fos_user.user_manager')->updateUser($user->getUser(), false);
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->prePersist($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof User) {
            $this->container->get('enigmatic_crm.mailer.user')->newUser($args->getEntity(), $this->password);
        }
    }
}