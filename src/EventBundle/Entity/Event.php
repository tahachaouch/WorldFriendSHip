<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="EventBundle\Repository\EventRepository")
 */
class Event
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_event", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="nbrplace_event", type="integer", nullable=true)
     */
    private $nbrplaceEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="type_event", type="string", length=255)
     */
    private $typeEvent;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser",referencedColumnName="id")
     */
    private $iduser;

    /**
     * @return mixed
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param mixed $iduser
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }



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
     * Set nbrplaceEvent
     *
     * @param integer $nbrplaceEvent
     *
     * @return Event
     */
    public function setNbrplaceEvent($nbrplaceEvent)
    {
        $this->nbrplaceEvent = $nbrplaceEvent;

        return $this;
    }

    /**
     * Get nbrplaceEvent
     *
     * @return int
     */
    public function getNbrplaceEvent()
    {
        return $this->nbrplaceEvent;
    }

    /**
     * Set typeEvent
     *
     * @param string $typeEvent
     *
     * @return Event
     */
    public function setTypeEvent($typeEvent)
    {
        $this->typeEvent = $typeEvent;

        return $this;
    }



    /**
     * Get typeEvent
     *
     * @return string
     */
    public function getTypeEvent()
    {
        return $this->typeEvent;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="title_event", type="string", length=255)
     */
    private $title_Event;

    /**
     * @return string
     */
    public function getTitleEvent()
    {
        return $this->title_Event;
    }

    /**
     * @param string $title_Event
     */
    public function setTitleEvent($title_Event)
    {
        $this->title_Event = $title_Event;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="description_event", type="text")
     */
    private $description_Event;

    /**
     * @return string
     */
    public function getDescriptionEvent()
    {
        return $this->description_Event;
    }

    /**
     * @param string $description_Event
     */
    public function setDescriptionEvent($description_Event)
    {
        $this->description_Event = $description_Event;
    }
    /**
     * @ORM\Column(type="datetime")
     */
    private $startdateevent;

    /**
     * @return mixed
     */
    public function getStartdateevent()
    {
        return $this->startdateevent;
    }

    /**
     * @param mixed $startdateevent
     */
    public function setStartdateevent($startdateevent)
    {
        $this->startdateevent = $startdateevent;
    }
    /**
     * @ORM\Column(type="datetime")
     */
    private $enddateevent;

    /**
     * @return mixed
     */
    public function getEnddateevent()
    {
        return $this->enddateevent;
    }

    /**
     * @param mixed $enddateevent
     */
    public function setEnddateevent($enddateevent)
    {
        $this->enddateevent = $enddateevent;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="image_Event", type="string", length=255)
     */
    private $image_Event;

    /**
     * @return string
     */
    public function getImageEvent()
    {
        return $this->image_Event;
    }

    /**
     * @param string $image_Event
     */
    public function setImageEvent($image_Event)
    {
        $this->image_Event = $image_Event;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="adresse_Event", type="string", length=255)
     */
    private $adresse_Event;

    /**
     * @return string
     */
    public function getAdresseEvent()
    {
        return $this->adresse_Event;
    }

    /**
     * @param string $adresse_Event
     */
    public function setAdresseEvent($adresse_Event)
    {
        $this->adresse_Event = $adresse_Event;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="type_hebergement", type="string", length=255)
     */
    private $type_hebergement;

    /**
     * @return string
     */
    public function getTypeHebergement()
    {
        return $this->type_hebergement;
    }

    /**
     * @param string $type_hebergement
     */
    public function setTypeHebergement($type_hebergement)
    {
        $this->type_hebergement = $type_hebergement;
    }
    /**
     * @var string
     *
     * @ORM\Column(name="adressehebergement", type="string", length=255)
     */
    private $adressehebergement;

    /**
     * @return string
     */
    public function getAdressehebergement()
    {
        return $this->adressehebergement;
    }

    /**
     * @param string $adressehebergement
     */
    public function setAdressehebergement($adressehebergement)
    {
        $this->adressehebergement = $adressehebergement;
    }
}