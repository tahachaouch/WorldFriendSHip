<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 28/03/2019
 * Time: 23:14
 */

namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
class FileUploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        try {
            $file->move($this->getTargetDirectory(), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}