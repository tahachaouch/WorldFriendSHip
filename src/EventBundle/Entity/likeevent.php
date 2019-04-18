<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * likeevent
 *
 * @ORM\Table(name="likeevent")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\likeeventRepository")
 */
class likeevent
{
    /**
     * @var int
     *
     * @ORM\Column(name="idlike", type="integer")
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
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Event", inversedBy="aimes")
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
     * @return likeevent
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
     * @return likeevent
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

