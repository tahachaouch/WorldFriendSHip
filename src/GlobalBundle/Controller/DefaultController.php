<?php

namespace GlobalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function layoutAction()
    {

        return $this->render('GlobalBundle::layout.html.twig');
    }
}
