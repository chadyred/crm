<?php

namespace Enigmatic\CRMBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Enigmatic\CRMBundle\Entity\CampaignMailingFile;

class CampaignMailingFileListener
{
    protected $path;

    public function prePersist(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof CampaignMailingFile) {
            $file = $args->getEntity();
            if ($file->getFile() !== null) {

                if (!$file->getId())
                    $file->setDateCreated(new \DateTime());
                $file->setDateUpdated(new \DateTime());

                $extension = $file->getFile()->guessExtension();
                $file->setPath(sha1(uniqid(mt_rand(), true)).'.'.$extension);
                if (file_exists($file->getAbsolutePath())){
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
        if ($args->getEntity() instanceof CampaignMailingFile) {
            $file = $args->getEntity();
            if ($file->getFile() === null)
                return;

            $file->getFile()->move($file->getUploadRootDir(), $file->getPath());
        }
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->postPersist($args);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof CampaignMailingFile) {
            $file = $args->getEntity();
            $this->path = $file->getAbsolutePath();
        }
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        if ($args->getEntity() instanceof CampaignMailingFile) {
            if (file_exists($this->path)) {
                unlink($this->path);
            }
        }
    }
}