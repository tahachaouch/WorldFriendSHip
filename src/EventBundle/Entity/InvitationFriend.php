<?php

namespace EventBundle\Entity;

/**
 * InvitationFriend
 */
class InvitationFriend
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $idusersender;

    /**
     * @var int
     */
    private $iduserreciever;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id_invitation;
    }

    /**
     * Set idusersender
     *
     * @param integer $idusersender
     *
     * @return InvitationFriend
     */
    public function setIdusersender($idusersender)
    {
        $this->idusersender = $idusersender;

        return $this;
    }

    /**
     * Get idusersender
     *
     * @return int
     */
    public function getIdusersender()
    {
        return $this->idusersender;
    }

    /**
     * Set iduserreciever
     *
     * @param integer $iduserreciever
     *
     * @return InvitationFriend
     */
    public function setIduserreciever($iduserreciever)
    {
        $this->iduserreciever = $iduserreciever;

        return $this;
    }

    /**
     * Get iduserreciever
     *
     * @return int
     */
    public function getIduserreciever()
    {
        return $this->iduserreciever;
    }
}

