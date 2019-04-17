<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class Question
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_question", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idQuestion;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="date_question", type="string", length=50, nullable=false)
     */
    private $dateQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_question", type="string", length=250, nullable=false)
     */
    private $titreQuestion;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu_question", type="string", length=2500, nullable=false)
     */
    private $contenuQuestion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="etat_question", type="boolean", nullable=false)
     */
    private $etatQuestion = '1';


}

