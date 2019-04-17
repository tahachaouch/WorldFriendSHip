<?php

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event", indexes={@ORM\Index(name="IDX_3BAE0AA75E5C27E9", columns={"iduser"})})
 * @ORM\Entity
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvent;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbrplace_event", type="integer", nullable=true)
     */
    private $nbrplaceEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="type_event", type="string", length=255, nullable=false)
     */
    private $typeEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="title_event", type="string", length=255, nullable=false)
     */
    private $titleEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="description_event", type="text", nullable=false)
     */
    private $descriptionEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="startdateevent", type="datetime", nullable=false)
     */
    private $startdateevent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="enddateevent", type="datetime", nullable=false)
     */
    private $enddateevent;

    /**
     * @var string
     *
     * @ORM\Column(name="image_Event", type="string", length=255, nullable=false)
     */
    private $imageEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse_Event", type="string", length=255, nullable=false)
     */
    private $adresseEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="type_hebergement", type="string", length=255, nullable=false)
     */
    private $typeHebergement;

    /**
     * @var string
     *
     * @ORM\Column(name="adressehebergement", type="string", length=255, nullable=false)
     */
    private $adressehebergement;

    /**
     * @var \FosUser
     *
     * @ORM\ManyToOne(targetEntity="FosUser")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id")
     * })
     */
    private $iduser;


}

