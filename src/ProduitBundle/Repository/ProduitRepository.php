<?php
/**
 * Created by PhpStorm.
 * User: Meriem
 * Date: 13/04/2019
 * Time: 14:13
 */

namespace ProduitBundle\Repository;
use Doctrine\ORM\EntityRepository;
use ProduitBundle\Entity\Produit;
use Doctrine\ORM\Query;


class ProduitRepository extends EntityRepository
{

    public function findProduitByid($id)
    {
        return $this->getEntityManager()
            ->createQuery("select p from ProduitBundle:Produit p where p.nomProd LIKE :id")
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }

    public function byCategorie($idCat)
    {
        $qb = $this->createQueryBuilder('u')
            ->select('u')
            ->where('u.idCat =: idCat')
            ->orderBy('u.id')
            ->setParameter('idCat',$idCat);
            return $qb->getQuery()->getResult();

    }

    public function findEntitesByString($str)
    {
        return $this->getEntityManager()
            ->createQuery('select p from ProduitBundle:Produit p where p.nomProd LIKE :str')
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }


}