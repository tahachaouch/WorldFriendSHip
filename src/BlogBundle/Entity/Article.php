<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\ArticleRepository")
 */
class Article
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
    private $iduser;

    /**
     * @var string
     *
     * @ORM\Column(name="titre_article", type="string", length=255)
     */
    private $titreArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="blog", type="text")
     */
    private $blog;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     * @Assert\NotBlank(message="Please, upload the product brochure as a PDF file.")
     * @Assert\File(mimeTypes={ "application/pdf" })
     */
    public $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="cree", type="date",nullable=true)
     */
    private $cree;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifie", type="date",nullable=true)
     */
    private $modifie;

    /**
     * @var bool
     *
     * @ORM\Column(name="archive", type="boolean",nullable=true)
     */
    private $archive;

    /**
     * @var string
     *
     * @ORM\Column(name="tags", type="string", length=255,nullable=true)
     */


    /**
     * @var array
     *
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
     */
    private $tags;
    /**
     * Add tag
     *
     * @param $tag
     *
     * @return mixed
     */
    public function addTag(Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param Tag $tag
     */
    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
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
     * @return Article
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
     * Set titreArticle
     *
     * @param string $titreArticle
     *
     * @return Article
     */
    public function setTitreArticle($titreArticle)
    {
        $this->titreArticle = $titreArticle;

        return $this;
    }

    /**
     * Get titreArticle
     *
     * @return string
     */
    public function getTitreArticle()
    {
        return $this->titreArticle;
    }

    /**
     * Set blog
     *
     * @param string $blog
     *
     * @return Article
     */
    public function setBlog($blog)
    {
        $this->blog = $blog;

        return $this;
    }

    /**
     * Get blog
     *
     * @return string
     */
    public function getBlog()
    {
        return $this->blog;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Article
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set cree
     *
     * @param \DateTime $cree
     *
     * @return Article
     */
    public function setCree($cree)
    {
        $this->cree = $cree;

        return $this;
    }

    /**
     * Get cree
     *
     * @return \DateTime
     */
    public function getCree()
    {
        return $this->cree;
    }

    /**
     * Set modifie
     *
     * @param \DateTime $modifie
     *
     * @return Article
     */
    public function setModifie($modifie)
    {
        $this->modifie = $modifie;

        return $this;
    }

    /**
     * Get modifie
     *
     * @return \DateTime
     */
    public function getModifie()
    {
        return $this->modifie;
    }

    /**
     * Set archive
     *
     * @param boolean $archive
     *
     * @return Article
     */
    public function setArchive($archive)
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * Get archive
     *
     * @return bool
     */
    public function getArchive()
    {
        return $this->archive;
    }

    /**
     * Set tags
     *
     * @param string $tags
     *
     * @return Article
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return string
     */
    public function getTags()
    {
        return $this->tags;
    }
    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\likearticle", mappedBy="idArticle")
     *
     */
    private $aimes;

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
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Commentarticle", mappedBy="idArticle")
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
     * @var int
     *
     * @ORM\Column(name="nbreComment", type="integer",nullable=true)
     *
     */
    private $nbreComment;

    /**
     * @return int
     */
    public function getNbreComment()
    {
        return $this->nbreComment;
    }

    /**
     * @param int $nbreLike
     */
    public function setNbreComment($nbreComment)
    {
        $this->nbreComment = $nbreComment;
    }


    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Categorie",cascade={"persist"})
     * @ORM\JoinColumn(name="Categorie",referencedColumnName="id",nullable=true, onDelete="SET NULL")
     */
    private $Categorie;

    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->Categorie;
    }

    /**
     * @param mixed $Categorie
     */
    public function setCategorie(\BlogBundle\Entity\Categorie $Categorie)
    {
        $this->Categorie = $Categorie;
    }


}

