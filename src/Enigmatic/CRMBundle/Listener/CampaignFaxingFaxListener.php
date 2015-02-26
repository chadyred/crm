<?php

namespace Enigmatic\CRMBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Enigmatic\CRMBundle\Entity\CampaignFaxingFax;

class CampaignFaxingFaxListener
{
    protected $path;

    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof CampaignFaxingFax) {
            $fax = $args->getEntity();
            if ($fax->getFile() !== null) {

                if (!$fax->getId())
                    $fax->setDateCreated(new \DateTime());
                $fax->setDateUpdated(new \DateTime());

                $extension = $fax->getFile()->guessExtension();
                $fax->setPath(sha1(uniqid(mt_rand(), true)).'.'.$extension);
                if (file_exists($fax->getAbsolutePath())){
                    throw new \Exception ("Try to remove a existing file");
                }
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->prePersist($args);
    }

    public function postPersist(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof CampaignFaxingFax) {
            $fax = $args->getEntity();
            if ($fax->getFile() === null)
                return;

            $fax->getFile()->move($fax->getUploadRootDir(), $fax->getPath());
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->postPersist($args);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof CampaignFaxingFax) {
            $fax = $args->getEntity();
            $this->path = $fax->getAbsolutePath();
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof CampaignFaxingFax) {
            if (file_exists($this->path)) {
                unlink($this->path);
            }
        }
    }
}