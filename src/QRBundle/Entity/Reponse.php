<?php

namespace QRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponse
 *
 * @ORM\Table(name="reponse", indexes={@ORM\Index(name="id_question", columns={"id_question"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity(repositoryClass="QRBundle\Repository\RpRepository")
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
     * @var string
     *
     * @ORM\Column(name="date_reponse", type="string", nullable=false)
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



    /**
     * Get idReponse
     *
     * @return integer
     */
    public function getIdReponse()
    {
        return $this->idReponse;
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Reponse
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
     * Set idQuestion
     *
     * @param integer $idQuestion
     *
     * @return Reponse
     */
    public function setIdQuestion($idQuestion)
    {
        $this->idQuestion = $idQuestion;

        return $this;
    }

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
     * Set dateReponse
     *
     * @param string $dateReponse
     *
     * @return Reponse
     */
    public function setDateReponse($dateReponse)
    {
        $this->dateReponse = $dateReponse;

        return $this;
    }

    /**
     * Get dateReponse
     *
     * @return string
     */
    public function getDateReponse()
    {
        return $this->dateReponse;
    }

    /**
     * Set contenuReponse
     *
     * @param string $contenuReponse
     *
     * @return Reponse
     */
    public function setContenuReponse($contenuReponse)
    {
        $this->contenuReponse = $contenuReponse;

        return $this;
    }

    /**
     * Get contenuReponse
     *
     * @return string
     */
    public function getContenuReponse()
    {
        return $this->contenuReponse;
    }

    /**
     * Set etatReponse
     *
     * @param integer $etatReponse
     *
     * @return Reponse
     */
    public function setEtatReponse($etatReponse)
    {
        $this->etatReponse = $etatReponse;

        return $this;
    }

    /**
     * Get etatReponse
     *
     * @return integer
     */
    public function getEtatReponse()
    {
        return $this->etatReponse;
    }
}
