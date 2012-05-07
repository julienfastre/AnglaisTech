<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SOFFT\AnglaisBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use SOFFT\AnglaisBundle\Entity\Mot;
use Doctrine\ORM\Query\ResultSetMapping;
use SOFFT\AnglaisBundle\Entity\Quizz;



/**
 * Description of QuizzController
 *
 * @author Julien Fastré
 */
class QuizzController extends Controller {
    
    
    public function indexAction() {
        $user =  $this->get('security.context')->getToken()->getUser();
        $quizzes  = $this->getDoctrine()
                ->getRepository('SOFFTAnglaisBundle:Quizz')
                ->getQuizzesOwnedBy($user);
        
        return $this->render('SOFFTAnglaisBundle:Quizz:liste.html.twig', 
                array('quizzes' => $quizzes,
                    'user' => $user));
    }
    
    public function createAction() {
        $em = $this->getDoctrine()->getEntityManager();
        
        $nb = 10;
        
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('SOFFT\AnglaisBundle\Entity\Mot', 'm');
        $rsm->addFieldResult('m', 'id', 'id');
        
        $mots = $em->createNativeQuery('SELECT id from mots order by RANDOM() limit :number', $rsm)
                ->setParameter('number', $nb)
                ->getResult();
        
        $q = new Quizz(Quizz::DRAG_AND_DROP1);
        
        $user =  $this->get('security.context')->getToken()->getUser();
        $q->setOwner($user);
        foreach ($mots as $m) {
            $q->addMot($m);
        }

        $em->persist($q);
        $em->flush();
        
        return $this->redirect($this->generateUrl('SAB_quizz_liste'));
        
    }
    
    public function playAction($quizzId) {
        $em = $this->getDoctrine()->getEntityManager();
        $user = $this->get('security.context')->getToken()->getUser();
        
        /**
         *@var SOFFT\AnglaisBundle\Entity\Quizz
         */
        $quizz = $em->getRepository('SOFFTAnglaisBundle:Quizz')->find($quizzId);
        
        //si le quizz n'existe pas...
        if($quizz == null) {
            throw $this->createNotFoundException("Le Quizz n'a pas été trouvé");
        }
        
        //vérifie que le quizz est autorisé...
        if ($quizz->getOwner()->getId() != $user->getId()) {
            throw new \Exception("Vous n'êtes pas autorisé à jouer à ce quizz");
        }
        
        switch ($quizz->getType()) {
            case Quizz::DRAG_AND_DROP1 : 
                return $this->render('SOFFTAnglaisBundle:Quizz:play_drag_and_drop_1.html.twig', array(
                    'user' => $user,
                    'quizz' => $quizz
                ));
                break;
            default: 
                throw $this->createNotFoundException("Le type de quizz n'a pas été associé à une vue");
                
        }
        
            
        
        
    }
}

