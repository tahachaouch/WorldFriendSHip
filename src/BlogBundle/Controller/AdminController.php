<?php
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 08/04/2019
 * Time: 17:07
 */

namespace BlogBundle\Controller;


use BlogBundle\Entity\Categorie;
use BlogBundle\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
class AdminController extends Controller
{
    public function AddCategorieAction(Request $request)
    { $Categorie=new Categorie();

        $form = $this->createForm(CategorieType::class, $Categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {


            $em = $this->getDoctrine()->getManager();

            $em->persist($Categorie);
            $em->flush();
            return $this->redirectToRoute('Admin_List_Categories');
        }
 return $this->render("BlogBundle:Admin:AddCategorie.html.twig", array(
'form' => $form->createView()
));




}
    public function listCategoriesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $Categorie = $em->getRepository("BlogBundle:Categorie")->findAll();


        $dql = "select Categorie from BlogBundle:Categorie Categorie ";
        $query = $em->createQuery($dql);
        $paginator1  = $this->get('knp_paginator');
        $pagination1 = $paginator1->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/);


        return $this->render("BlogBundle:Admin:ListCategories.html.twig",
            array('Categorie' => $Categorie,'pagination1' => $pagination1,
            ));
    }
    public function deleteCategorieAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $Article = $em->getRepository("BlogBundle:Categorie")->find($id);
        $em->remove($Article);
        $em->flush();
        return $this->redirectToRoute('Admin_List_Categories');
    }


    public function updateCategorieAction($id,Request $request)
    {$categorie=$this->getDoctrine()->getRepository(Categorie::class)->find($id);
    $form=$this->createForm(CategorieType::class,$categorie);
    $form->handleRequest($request);
        if($form->isValid())
        {

            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('Admin_List_Categories');
        }
        return $this->render("BlogBundle:Admin:updateCategorie.html.twig"
            ,array("form"=>$form->createView()));
    }



}