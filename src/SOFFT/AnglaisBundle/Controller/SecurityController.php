<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use SOFFT\AnglaisBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

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
    
    public function newAction(Request $request) {
        $user = new User;
        
        $form = $this->createFormBuilder($user)
                ->add('username', 'text')
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'first_name' => 'Mot de passe :',
                    'second_name' => 'Répétez votre mot de passe',
                    'invalid_message' => 'Les deux mots de passe ne correspondent pas'
                ))
                ->getForm();
        
        if($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                
                
                
                $user = $form->getData();

                $factory = $this->get('security.encoder_factory');

                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password);
                $this->getDoctrine()->getEntityManager()->persist($user);
                $this->getDoctrine()->getEntityManager()->flush();
                                
                return $this->redirect($this->generateUrl('SAB_account_welcome', array('username' => $user->getUsername() ) ));
            }
        }
        
        
        return $this->render('SOFFTAnglaisBundle:Security:createaccount.html.twig', array("form" => $form->createView()));
        
    }
    
    public function welcomeAction($username) {
        return $this->render('SOFFTAnglaisBundle:Security:welcome.html.twig', array('username' => $username));
    }
    
    
}

