<?php

namespace CommandeBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion", indexes={@ORM\Index(name="fk_foreign_id_prodt", columns={"id_prod"})})
 * @ORM\Entity(repositoryClass="CommandeBundle\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_promo", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPromo;

    /**
     * @var float
     *
     * @ORM\Column(name="pourcentage", type="float", precision=10, scale=0, nullable=false)
    /** @Assert\Range(max=99) */

    private $pourcentage;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_promo", type="datetime", nullable=false)
     */
    private $datePromo;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="CommandeBundle\Entity\Produit")
     * @ORM\JoinColumn(name="id_prod",referencedColumnName="id_prod")
     */
    private $idProd;

    /**
     * @return int
     */
    public function getIdPromo()
    {
        return $this->idPromo;
    }

    /**
     * @param int $idPromo
     */
    public function setIdPromo($idPromo)
    {
        $this->idPromo = $idPromo;
    }

    /**
     * @return float
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }

    /**
     * @param float $pourcentage
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage;
    }

    /**
     * @return \DateTime
     */
    public function getDatePromo()
    {
        return $this->datePromo;
    }

    /**
     * @param \DateTime $datePromo
     */
    public function setDatePromo($datePromo)
    {
        $this->datePromo = $datePromo;
    }

    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getIdProd()
    {
        return $this->idProd;
    }

    /**
     * @param mixed $id_prod
     */
    public function setIdProd($idProd)
    {
        $this->idProd = $idProd;
    }


}
