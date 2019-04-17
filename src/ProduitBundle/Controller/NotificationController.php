<?php
/**
 * Created by PhpStorm.
 * User: Meriem
 * Date: 16/04/2019
 * Time: 14:04
 */

namespace ProduitBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NotificationController extends Controller
{
    public function displayAction()
    {

        $categories = $em->getRepository('ProduitBundle:Categorie')->findAll();
    }

}