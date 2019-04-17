<?php
/**
 * Created by PhpStorm.
 * User: Meriem
 * Date: 15/04/2019
 * Time: 10:45
 */

namespace ProduitBundle\Entity;


/**
 * Wishlist
 *
 * @ORM\Table(name="wishlist", indexes={@ORM\Index(name="fk_client_numero", columns={"id_user"}), @ORM\Index(name="fk_com_prod", columns={"id_prod"})})
 * @ORM\Entity
 */
class Wishlist
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * */
    private $id;
     /**
     * @var \Produit
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumn(name="id_prod", referencedColumnName="id")
     *
     */
    private $idProd;
    /**
     * @var \User
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     *
     */
    private $idUser;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \Produit
     */
    public function getIdProd()
    {
        return $this->idProd;
    }

    /**
     * @param \Produit $idProd
     */
    public function setIdProd($idProd)
    {
        $this->idProd = $idProd;
    }

    /**
     * @return \User
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * @param \User $idUser
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }




}