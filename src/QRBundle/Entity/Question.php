<?php

namespace QRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question", indexes={@ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="QRBundle\Repository\QrRepository")
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



    /**
     * Get idQuestion
     *
     * @return integer
     */
    public function getIdQuestion()
    {
        return $this->idQuestion;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Question
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateQuestion
     *
     * @param string $dateQuestion
     *
     * @return Question
     */
    public function setDateQuestion($dateQuestion)
    {
        $this->dateQuestion = $dateQuestion;

        return $this;
    }

    /**
     * Get dateQuestion
     *
     * @return string
     */
    public function getDateQuestion()
    {
        return $this->dateQuestion;
    }

    /**
     * Set titreQuestion
     *
     * @param string $titreQuestion
     *
     * @return Question
     */
    public function setTitreQuestion($titreQuestion)
    {
        $this->titreQuestion = $titreQuestion;

        return $this;
    }

    /**
     * Get titreQuestion
     *
     * @return string
     */
    public function getTitreQuestion()
    {
        return $this->titreQuestion;
    }

    /**
     * Set contenuQuestion
     *
     * @param string $contenuQuestion
     *
     * @return Question
     */
    public function setContenuQuestion($contenuQuestion)
    {
        $this->contenuQuestion = $contenuQuestion;

        return $this;
    }

    /**
     * Get contenuQuestion
     *
     * @return string
     */
    public function getContenuQuestion()
    {
        return $this->contenuQuestion;
    }

    /**
     * Set etatQuestion
     *
     * @param boolean $etatQuestion
     *
     * @return Question
     */
    public function setEtatQuestion($etatQuestion)
    {
        $this->etatQuestion = $etatQuestion;

        return $this;
    }

    /**
     * Get etatQuestion
     *
     * @return boolean
     */
    public function getEtatQuestion()
    {
        return $this->etatQuestion;
    }
}
