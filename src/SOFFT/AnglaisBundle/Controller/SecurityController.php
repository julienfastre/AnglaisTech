<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use SOFFT\AnglaisBundle\Entity\User;

/**
 * Description of securityController
 *
 * @author julien
 */
class securityController extends Controller {
    
    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('SOFFTAnglaisBundle:Security:login.html.twig', array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error'         => $error,
        ));
    }
    
    public function newAction() {
        $user = new User;
        
        $form = $this->createFormBuilder($user)
                ->add('username')
                ->add('password')
                ->getForm();
        
        return $this->render('SOFFTAnglaisBundle:Security:createaccount.html.twig', array("form" => $form->createView()));
        
    }
    
    
}

