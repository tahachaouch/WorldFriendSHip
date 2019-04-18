<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\ReservationRepository")
 */
class Reservation
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
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Event", inversedBy="participes")
     * @ORM\JoinColumn(name="idevent",referencedColumnName="id_event",onDelete="CASCADE")
     */
    private $idevent;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser",referencedColumnName="id")
     */
    private $iduser;

    /**
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Hebergement", inversedBy="participes")
     * @ORM\JoinColumn(name="idhebergement",referencedColumnName="id",onDelete="CASCADE")
     */
    private $idhebergement;

    /**
     * @return mixed
     */
    public function getIdhebergement()
    {
        return $this->idhebergement;
    }

    /**
     * @param mixed $idhebergement
     */
    public function setIdhebergement($idhebergement)
    {
        $this->idhebergement = $idhebergement;
    }


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dated", type="date")
     */
    private $dated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datef", type="date")
     */
    private $datef;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre", type="integer")
     */
    private $nombre;


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
     * Set idevent
     *
     * @param integer $idevent
     *
     * @return Reservation
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;

        return $this;
    }

    /**
     * Get idevent
     *
     * @return int
     */
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return Reservation
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;

        return $this;
    }

    /**
     * Get iduser
     *
     * @return int
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @return \DateTime
     */
    public function getDated()
    {
        return $this->dated;
    }

    /**
     * @param \DateTime $dated
     */
    public function setDated($dated)
    {
        $this->dated = $dated;
    }



    /**
     * Set nombre
     *
     * @param integer $nombre
     *
     * @return Reservation
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return int
     */
    public function getNombre()
    {
        return $this->nombre;
    }
    /**
     * @ORM\Column (name="nb",type="integer",nullable=true)
     */
    private $nb;

    /**
     * @return mixed
     */
    public function getNb()
    {
        return $this->nb;
    }

    /**
     * @param mixed $nb
     */
    public function setNb($nb)
    {
        $this->nb = $nb;
    }

    /**
     * @return \DateTime
     */
    public function getDatef()
    {
        return $this->datef;
    }

    /**
     * @param \DateTime $datef
     */
    public function setDatef($datef)
    {
        $this->datef = $datef;
    }

}

