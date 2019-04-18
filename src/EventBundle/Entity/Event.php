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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser",referencedColumnName="id")
     */
    private $iduser;


    /**
     * @var int
     *
     * @ORM\Column(name="nbrplace_event", type="integer")
     */
    private $nbrplaceEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="type_event", type="string", length=255)
     */
    private $typeEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="title_event", type="string", length=255)
     */
    private $titleEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="description_event", type="text", length=255,nullable=false)
     */
    private $descriptionEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdateevent", type="date",nullable=false)
     */
    private $startdateevent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddateevent", type="date",nullable=false)
     */
    private $enddateevent;

    /**
     * @var string
     *
     * @ORM\Column(name="image_Event", type="string", length=255)
     */
    private $imageEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_Event", type="string", length=255)
     */
    private $adresseEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="type_hebergement", type="string", length=255)
     */
    private $typeHebergement;

    /**
     * @var string
     *
     * @ORM\Column(name="adressehebergement", type="string", length=255)
     */
    private $adressehebergement;

    /**
     * @ORM\OneToMany(targetEntity="EventBundle\Entity\Review", mappedBy="idEvent")
     *
     */
    private $comments;

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getCommentCount(){
        return count($this->comments);
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
     * Set iduser
     *
     * @param integer $iduser
     *
     * @return Event
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
     * Set titleEvent
     *
     * @param string $titleEvent
     *
     * @return Event
     */
    public function setTitleEvent($titleEvent)
    {
        $this->titleEvent = $titleEvent;

        return $this;
    }

    /**
     * Get titleEvent
     *
     * @return string
     */
    public function getTitleEvent()
    {
        return $this->titleEvent;
    }

    /**
     * Set descriptionEvent
     *
     * @param text $descriptionEvent
     *
     * @return Event
     */
    public function setDescriptionEvent($descriptionEvent)
    {
        $this->descriptionEvent = $descriptionEvent;

        return $this;
    }

    /**
     * Get descriptionEvent
     *
     * @return string
     */
    public function getDescriptionEvent()
    {
        return $this->descriptionEvent;
    }

    /**
     * Set startdateevent
     *
     * @param \DateTime $startdateevent
     *
     * @return Event
     */
    public function setStartdateevent($startdateevent)
    {
        $this->startdateevent = $startdateevent;

        return $this;
    }

    /**
     * Get startdateevent
     *
     * @return \DateTime
     */
    public function getStartdateevent()
    {
        return $this->startdateevent;
    }

    /**
     * Set enddateevent
     *
     * @param \DateTime $enddateevent
     *
     * @return Event
     */
    public function setEnddateevent($enddateevent)
    {
        $this->enddateevent = $enddateevent;

        return $this;
    }

    /**
     * Get enddateevent
     *
     * @return \DateTime
     */
    public function getEnddateevent()
    {
        return $this->enddateevent;
    }

    /**
     * Set imageEvent
     *
     * @param string $imageEvent
     *
     * @return Event
     */
    public function setImageEvent($imageEvent)
    {
        $this->imageEvent = $imageEvent;

        return $this;
    }

    /**
     * Get imageEvent
     *
     * @return string
     */
    public function getImageEvent()
    {
        return $this->imageEvent;
    }

    /**
     * Set adresseEvent
     *
     * @param string $adresseEvent
     *
     * @return Event
     */
    public function setAdresseEvent($adresseEvent)
    {
        $this->adresseEvent = $adresseEvent;

        return $this;
    }

    /**
     * Get adresseEvent
     *
     * @return string
     */
    public function getAdresseEvent()
    {
        return $this->adresseEvent;
    }

    /**
     * Set typeHebergement
     *
     * @param string $typeHebergement
     *
     * @return Event
     */
    public function setTypeHebergement($typeHebergement)
    {
        $this->typeHebergement = $typeHebergement;

        return $this;
    }

    /**
     * Get typeHebergement
     *
     * @return string
     */
    public function getTypeHebergement()
    {
        return $this->typeHebergement;
    }

    /**
     * Set adressehebergement
     *
     * @param string $adressehebergement
     *
     * @return Event
     */
    public function setAdressehebergement($adressehebergement)
    {
        $this->adressehebergement = $adressehebergement;

        return $this;
    }

    /**
     * Get adressehebergement
     *
     * @return string
     */
    public function getAdressehebergement()
    {
        return $this->adressehebergement;
    }

    /**
     * @ORM\OneToMany(targetEntity="EventBundle\Entity\likeevent", mappedBy="idevent")
     *
     */
    private $aimes;

    /**
     * @ORM\OneToMany(targetEntity="EventBundle\Entity\participation", mappedBy="idevent")
     *
     */
    private $participes;

    /**
     * @return mixed
     */
    public function getParticipes()
    {
        return $this->participes;
    }

    /**
     * @param mixed $participes
     */
    public function setParticipes($participes)
    {
        $this->participes = $participes;
    }


    /**
     * @return mixed
     */
    public function getAimes()
    {
        return $this->aimes;
    }

    /**
     * @param mixed $aimes
     */
    public function setAimes($aimes)
    {
        $this->aimes = $aimes;
    }
    public function getLikeCount(){
        return count($this->aimes);
    }

    public function getPartCount(){
        return count($this->participes);
    }
    /**
     * @var int
     *
     * @ORM\Column(name="nbreLike", type="integer",nullable=true)
     *
     */
    private $nbreLike;

    /**
     * @return int
     */
    public function getNbreLike()
    {
        return $this->nbreLike;
    }

    /**
     * @param int $nbreLike
     */
    public function setNbreLike($nbreLike)
    {
        $this->nbreLike = $nbreLike;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="nbrPart", type="integer",nullable=true)
     *
     */
    private $nbrPart;

    /**
     * @return int
     */
    public function getNbrPart()
    {
        return $this->nbrPart;
    }

    /**
     * @param int $nbrPart
     */
    public function setNbrPart($nbrPart)
    {
        $this->nbrPart = $nbrPart;
    }
}

