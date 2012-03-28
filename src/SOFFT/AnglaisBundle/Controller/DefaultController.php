<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('SOFFTAnglaisBundle:Default:index.html.twig', array('name' => $name));
    }
}
