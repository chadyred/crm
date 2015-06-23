<?php

namespace Enigmatic\CRMBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Enigmatic\CRMBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AccountListener
{

    public function prePersist(LifecycleEventArgs $args)
    {
        // Synchro societe.com ?
    }

    public function preUpdate(LifecycleEventArgs $args)
    {

    }

    public function postPersist(LifecycleEventArgs $args)
    {
        // Synchro societe.com ?
    }

    public function postUpdate(LifecycleEventArgs $args)
    {

    }
}