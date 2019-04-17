<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="id_question", columns={"id_question"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Reponse
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_reponse", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idReponse;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_question", type="integer", nullable=false)
     */
    private $idQuestion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reponse", type="datetime", nullable=false)
     */
    private $dateReponse;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_reponse", type="string", length=250, nullable=false)
     */
    private $contenuReponse;

    /**
     * @var integer
     *
     * @ORM\Column(name="etat_reponse", type="smallint", nullable=false)
     */
    private $etatReponse = '1';


}

