<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Hebergement
 *
 * @ORM\Table(name="hebergement")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\HebergementRepository")
 * @Vich\Uploadable
 */
class Hebergement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="adresseh", type="string", length=255)
     */
    private $adresseh;

    /**
     * @var int
     *
     * @ORM\Column(name="prixn", type="integer")
     */
    private $prixn;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", length=255)
     */
    private $description;


    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="nomh", type="string", length=255)
     */
    private $nomh;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser",referencedColumnName="id")
     */
    private $iduser;

    /**
     * @return mixed
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param mixed $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set adresseh
     *
     * @param string $adresseh
     *
     * @return Hebergement
     */
    public function setAdresseh($adresseh)
    {
        $this->adresseh = $adresseh;

        return $this;
    }

    /**
     * Get adresseh
     *
     * @return string
     */
    public function getAdresseh()
    {
        return $this->adresseh;
    }

    /**
     * Set prixn
     *
     * @param integer $prixn
     *
     * @return Hebergement
     */
    public function setPrixn($prixn)
    {
        $this->prixn = $prixn;

        return $this;
    }

    /**
     * Get prixn
     *
     * @return int
     */
    public function getPrixn()
    {
        return $this->prixn;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Hebergement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Hebergement
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set nomh
     *
     * @param string $nomh
     *
     * @return Hebergement
     */
    public function setNomh($nomh)
    {
        $this->nomh = $nomh;

        return $this;
    }

    /**
     * Get nomh
     *
     * @return string
     */
    public function getNomh()
    {
        return $this->nomh;
    }

    /**
     * @Vich\UploadableField(mapping="devis", fileNameProperty="devisName")
     *
     * @var File
     */
    private $devisFile;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $devisName;

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $devis
     *
     * @return Devis
     */
    public function setDevisFile(File $devis = null)
    {
        $this->devisFile = $devis;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getDevisFile()
    {
        return $this->devisFile;
    }

    /**
     * @param string $devisName
     *
     * @return Devis
     */
    public function setDevisName($devisName)
    {
        $this->devisName = $devisName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDevisName()
    {
        return $this->devisName;
    }
    /**
     * @var integer
     *
     * @ORM\Column(name="place",  type="integer",nullable=true)
     */
    private $place;

    /**
     * @return int
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @param int $place
     */
    public function setPlace($place)
    {
        $this->place = $place;
    }

}

