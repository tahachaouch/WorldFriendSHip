<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 11/04/2019
 * Time: 12:15
 */

namespace EventBundle\Controller;


use EventBundle\Entity\Hebergement;
use EventBundle\Form\HebergementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;



class HebergementController extends Controller
{
    public function addhAction(Request $request){
        $heberg = new Hebergement();

        $form = $this->createForm(HebergementType::class,$heberg);

        $form->handleRequest($request);
        if ($form->isSubmitted() && ($form->isValid())) {
            $heberg->setIduser($user = $this->getUser());

            $em = $this->getDoctrine()->getManager();
            $em->persist($heberg);
            $em->flush();
            return $this->redirectToRoute('heberg_list');
        }

        return $this->render("EventBundle:Event:AddHeberg.html.twig", array(
            "form" => $form->createView()));

    }



    public function listhAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $heberg = $em->getRepository('EventBundle:Hebergement')->findAll();
        if ($request->isMethod('POST')) {
            {
                $title_heberg = $request->get('nomh');

                $heberg = $em->getRepository("EventBundle:Hebergement")
                    ->findBy(array("nomh" => $title_heberg));
                //  $this->redirectToRoute('App_bon_plan_list_article');
            }
        }

        /////nearest event
        $dql = "select Hebergement from EventBundle:Hebergement Hebergement ORDER BY Hebergement.prixn ASC ";
        $query = $em->createQuery($dql);
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            6/*limit per page*/);


        return $this->render("EventBundle:Event:Hebergs.html.twig",
            array('Hebergement' => $heberg,
                'pagination' => $pagination,

            ));

    }
    public function singlehAction(Request $request){
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        //   $Themes = $em->getRepository("OnsBundle:Theme")->findAll();
        $heberg = $em->getRepository("EventBundle:Hebergement")
            ->find($id);
        $nom = $heberg->getNomh();
        $addr = $heberg->getAdresseh();
        $img= $heberg->getDevisName();
        $desc=$heberg->getDescription();
        $phone=$heberg->getPhone();
        $prix=$heberg->getPrixn();
        //$user = $heberg->getIduser();

        return $this->render("EventBundle:Event:SingleHeberg.html.twig"
            , array(
                "id" => $id,
                "nom"=>$nom,
                "addresse=>$addr",
                "descr"=>$desc,
                "phone"=>$phone,
                "prix"=>$prix,
                "image"=>$img
            ));

    }

    public function deletehAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $heberg = $em->getRepository("EventBundle:Hebergement")->find($id);
        $em->remove($heberg);
        $em->flush();
        return $this->redirectToRoute('heberg_list');
    }

    public function updatehAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $heberg = $em->getRepository("EventBundle:Hebergement")
            ->find($id);

        $form = $this->createForm(HebergementType::class, $heberg);
        $form->handleRequest($request);

        if ($form->isValid() && ($form->isValid())) {


            $em->persist($heberg);
            $em->flush();
            return $this->redirectToRoute('heberg_list');
        }
        return $this->render("EventBundle:Event:UpdateHeberg.html.twig"
            , array("form" => $form->createView()));
    }

}