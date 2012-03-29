<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SOFFT\AnglaisBundle\Entity\User;

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
    
    public function viewAction($motId, Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        
        $mot = $em->getRepository('SOFFTAnglaisBundle:Mot')->find($motId);
        $user = $this->get('security.context')->getToken()->getUser();
        
        $mot->cadenas($user);
        $em->flush();
        
        $form = $this->createForm(new \SOFFT\AnglaisBundle\Form\MotType(), $mot);
        
        return $this->render('SOFFTAnglaisBundle:Mot:view.html.twig', array('form' => $form->createView(), 'mot' => $mot));
    }
}


