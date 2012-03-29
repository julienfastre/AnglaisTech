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
        
        if ($mot == NULL) 
        {
            throw $this->createNotFoundException("Le mot demandé n'existe pas");
        }
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        if ($mot->isBeingCadenas() && !$user->equals($mot->getCadenasWho()) )
        {
            return $this->render("SOFFTAnglaisBundle:Mot:motinaccessible.html.twig", array("mot" => $mot, "user" => $mot->getCadenasWho()));
        }
        
        
        
        
        $mot->cadenas($user);
        $em->flush();
        
        $form = $this->createForm(new \SOFFT\AnglaisBundle\Form\MotType(), $mot);
        
        return $this->render('SOFFTAnglaisBundle:Mot:view.html.twig', array('form' => $form->createView(), 'mot' => $mot));
    }
}


