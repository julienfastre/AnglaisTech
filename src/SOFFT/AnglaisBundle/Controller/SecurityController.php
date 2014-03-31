<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use SOFFT\AnglaisBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use CL\PersonaUserBundle\CLPersonaUserBundle;
use SOFFT\AnglaisBundle\Form\UserType;

/**
 * Description of securityController
 *
 * @author julien
 */
class securityController extends Controller {
    
    public function loginAction() {
        return $this->render('SOFFTAnglaisBundle:Security:login.html.twig');
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
                $this->getDoctrine()->getManager()->persist($user);
                $this->getDoctrine()->getManager()->flush();
                                
                return $this->redirect($this->generateUrl('SAB_account_welcome', array('username' => $user->getUsername() ) ));
            }
        }
        
        
        return $this->render('SOFFTAnglaisBundle:Security:createaccount.html.twig', array("form" => $form->createView()));
        
    }
    
    public function welcomeAction($username) {
        return $this->render('SOFFTAnglaisBundle:Security:welcome.html.twig', array('username' => $username));
    }
    
    public function registerAction(Request $request) {
        $emailRecorded = $this->get('session')
                ->get(CLPersonaUserBundle::KEY_EMAIL_SESSION, null);

        

        if ($emailRecorded === NULL) {
            $response = new Response("You must authenticate with persona first!");
            $response->setStatusCode(Response::HTTP_NOT_ACCEPTABLE);
            return $response;
        }

        

        $user = new User();
        $user->setPersonaId($emailRecorded);
        

        

        $form = $this->createForm(new UserType(), $user);

        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                

                #Authenticate the user immediatly

                $this->get('cl_persona_user.manual_login')
                      ->authenticate($user);
                
                $this->get('session')->getFlashBag()->set('notice', 'Bienvenue, '.
                        $user->getUsername());
                
                return $this->redirect(
                      $this->generateUrl('SAB_homepage'));

            } 

        }

        return $this->render('SOFFTAnglaisBundle:Register:form.html.twig', array(
                    'form' => $form->createView()
                        )
        );

        
    }
    
    public function logoutAction() {
        return new Response("ok");
    }
    
    
}

