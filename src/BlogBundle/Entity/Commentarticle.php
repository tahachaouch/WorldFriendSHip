<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * commentarticle
 *
 * @ORM\Table(name="commentarticle")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\commentarticleRepository")
 */
class Commentarticle
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
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="iduser",referencedColumnName="id")
     */
    private $idUser;


    /**

     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(name="id_article",referencedColumnName="id")
     */
    private $idArticle;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_comment", type="date")
     */
    private $dateComment;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;



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
     * Set idUser
     *
     * @param integer $idUser
     *
     * @return commentarticle
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * Get idUser
     *
     * @return int
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idArticle
     *
     * @param integer $idArticle
     *
     * @return commentarticle
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;

        return $this;
    }

    /**
     * Get idArticle
     *
     * @return int
     */
    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * Set dateComment
     *
     * @param \DateTime $dateComment
     *
     * @return commentarticle
     */
    public function setDateComment($dateComment)
    {
        $this->dateComment = $dateComment;

        return $this;
    }

    /**
     * Get dateComment
     *
     * @return \DateTime
     */
    public function getDateComment()
    {
        return $this->dateComment;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return commentarticle
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}

