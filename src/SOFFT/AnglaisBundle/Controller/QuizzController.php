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
}

