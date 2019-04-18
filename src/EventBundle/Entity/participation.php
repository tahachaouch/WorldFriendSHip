<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * participation
 *
 * @ORM\Table(name="participation")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\participationRepository")
 */
class participation
{
    /**
     * @var int
     *
     * @ORM\Column(name="idp", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

     /**
      * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser",referencedColumnName="id")
     */
    private $iduser;

    /**
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Event", inversedBy="participes")
     * @ORM\JoinColumn(name="idevent",referencedColumnName="id_event")
     */
    private $idevent;


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
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return participation
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
     * Set idevent
     *
     * @param integer $idevent
     *
     * @return participation
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
}

