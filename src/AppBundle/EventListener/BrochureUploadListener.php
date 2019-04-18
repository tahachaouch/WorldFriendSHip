<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 23/03/2019
 * Time: 01:42
 */

namespace AppBundle\EventListener;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use EventBundle\Entity\Event;
use AppBundle\Service\FileUploader;

class BrochureUploadListener
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    private function uploadFile($entity)
    {
        // upload only works for Product entities
        if (!$entity instanceof Event) {
            return;
        }

        $file = $entity->getImageEvent();

        // only upload new files
        if ($file instanceof UploadedFile) {
            $fileName = $this->uploader->upload($file);
            $entity->setImageEvent(new File($this->uploader->getTargetDir().'/'.$fileName));
        }
    }
}