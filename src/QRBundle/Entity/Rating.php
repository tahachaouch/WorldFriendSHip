<?php

namespace QRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating", indexes={@ORM\Index(name="id_reponse", columns={"id_reponse"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="QRBundle\Repository\RaRepository")
 */
class Rating
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_reponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idReponse;

    /**
     * @var integer
     *
     * @ORM\Column(name="rate", type="integer", nullable=false)
     */
    private $rate = '0';

    /**
     * @var integer
     *
     * @ORM\Column(name="unrate", type="smallint", nullable=false)
     */
    private $unrate = '0';


}

