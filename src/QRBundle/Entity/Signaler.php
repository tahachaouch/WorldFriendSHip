<?php

namespace QRBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Signaler
 *
 * @ORM\Table(name="signaler", indexes={@ORM\Index(name="id", columns={"id"}), @ORM\Index(name="id_question", columns={"id_question"})})
 * @ORM\Entity(repositoryClass="QRBundle\Repository\SigRepository")
 */
class Signaler
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
     * @ORM\Column(name="id_question", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $idQuestion;

    /**
     * @var integer
     *
     * @ORM\Column(name="sig", type="integer", nullable=false)
     */
    private $sig = '0';

    /**
     * @var string
     *
     * @ORM\Column(name="cause", type="string", length=250, nullable=false)
     */
    private $cause;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_signaler", type="string", nullable=false)
     */
    private $dateSignaler;

    /**
     * @var integer
     *
     * @ORM\Column(name="vu", type="integer", nullable=false)
     */
    private $vu = '0';



    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Signaler
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
     * @return Signaler
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
     * Set sig
     *
     * @param integer $sig
     *
     * @return Signaler
     */
    public function setSig($sig)
    {
        $this->sig = $sig;

        return $this;
    }

    /**
     * Get sig
     *
     * @return integer
     */
    public function getSig()
    {
        return $this->sig;
    }

    /**
     * Set cause
     *
     * @param string $cause
     *
     * @return Signaler
     */
    public function setCause($cause)
    {
        $this->cause = $cause;

        return $this;
    }

    /**
     * Get cause
     *
     * @return string
     */
    public function getCause()
    {
        return $this->cause;
    }

    /**
     * Set dateSignaler
     *
     * @param string $dateSignaler
     *
     * @return Signaler
     */
    public function setDateSignaler($dateSignaler)
    {
        $this->dateSignaler = $dateSignaler;

        return $this;
    }

    /**
     * Get dateSignaler
     *
     * @return string
     */
    public function getDateSignaler()
    {
        return $this->dateSignaler;
    }

    /**
     * Set vu
     *
     * @param integer $vu
     *
     * @return Signaler
     */
    public function setVu($vu)
    {
        $this->vu = $vu;

        return $this;
    }

    /**
     * Get vu
     *
     * @return integer
     */
    public function getVu()
    {
        return $this->vu;
    }
}
