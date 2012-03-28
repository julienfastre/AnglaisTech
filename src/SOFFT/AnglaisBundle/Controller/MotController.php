<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Description of MotController
 *
 * @author julien
 */
class MotController extends Controller {
    
    public function listAction($page) {
        $em = $this->getDoctrine()->getEntityManager();
        
        $list = $em->getRepository('SOFFTAnglaisBundle:Mot')->findAll();
        
        return $this->render('SOFFTAnglaisBundle:Mot:list.html.twig', array ('list' => $list));
        
    }
}


