<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likeevent
 *
 * @ORM\Table(name="likeevent", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idevent", columns={"idevent"})})
 * @ORM\Entity
 */
class Likeevent
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idlike", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idlike;

    /**
     * @var integer
     *
     * @ORM\Column(name="iduser", type="integer", nullable=false)
     */
    private $iduser;

    /**
     * @var integer
     *
     * @ORM\Column(name="idevent", type="integer", nullable=false)
     */
    private $idevent;


}

