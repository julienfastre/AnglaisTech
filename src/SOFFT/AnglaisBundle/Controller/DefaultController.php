<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('SAB_liste_mot'));
        //return $this->render('SOFFTAnglaisBundle:Default:index.html.twig', array('name' => $name));
    }
}
