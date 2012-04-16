<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use SOFFT\AnglaisBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use SOFFT\AnglaisBundle\Entity\Mot;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


/**
 * Description of MotController
 *
 * @author julien
 */
class MotController extends Controller {
    
    public function listAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        
        //récupère la page courante
        $page = $request->get('page', NULL);
        
        if ($page === NULL) {
            //il faut reprendre la variable de la session
            $session = $this->getRequest()->getSession();
            $page = $session->get('page_list_mot');
            if ($page === NULL) {
                $page = 1;
            }
        }
        
        if ($page < 1) {
            throw new \Exception("le numéro de page ne peut pas être inférieur à 1");
        }
        
        //stocke la valeur de la page dans la session
        $this->getRequest()->getSession()->set('page_list_mot', $page);
        
        
        //crée la pagination
        $mots_par_page = 15;
        
        $query = $em->createQuery("SELECT count(m.id) FROM SOFFTAnglaisBundle:Mot m ");
        $nb_de_mots = $query->getSingleScalarResult();

        $page = $page -1; //il faut passer dans le format "informatique" (le premier = 0)
        $div = $nb_de_mots/$mots_par_page;
        $nb_de_page =  round($div, 0);
        if (($nb_de_mots % $mots_par_page) > 0) {
            $nb_de_page = $nb_de_page + 1;
        }
        
        $list = $em->getRepository('SOFFTAnglaisBundle:Mot')
                ->createQueryBuilder('m')
                ->orderBy('m.en', 'ASC')->orderBy('m.fr', 'ASC')
                ->setFirstResult($page * $mots_par_page)
                ->setMaxResults($mots_par_page)
                ->getQuery()
                ->getResult();
        
        return $this->render('SOFFTAnglaisBundle:Mot:list.html.twig', array (
            'list' => $list,
            'page' => (int) $page +1, //il faut se réajuster au format textuel (1= première)
            'nb_de_page' => (int) $nb_de_page
            )
                );
        
    }
    
    public function createAction(Request $request) {
        $mot = new Mot();
        
        $form = $this->createForm(new \SOFFT\AnglaisBundle\Form\MotType(), $mot);
        
        if($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                
                $mot = $form->getData();
                
                $mot->resetCadenas();

                if ($mot->getId() === NULL)
                    $this->getDoctrine()->getEntityManager()->persist($mot);
                $this->getDoctrine()->getEntityManager()->flush();
                
                $this->get('session')->setFlash('notice', 'Votre mot a été créé');
                                
                return $this->redirect($this->generateUrl('SAB_liste_mot'));
            }
        }
        
        
        return $this->render('SOFFTAnglaisBundle:Mot:view.html.twig', array('form' => $form->createView(), 'mot' => $mot));
        
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
        
        if($request->getMethod() == 'POST') {
            $form->bindRequest($request);
            
            if ($form->isValid()) {
                
                $mot = $form->getData();
                
                $mot->resetCadenas();

                if ($mot->getId() === NULL)
                    $this->getDoctrine()->getEntityManager()->persist($user);
                $this->getDoctrine()->getEntityManager()->flush();
                
                $this->get('session')->setFlash('notice', 'Vos modifications ont été enregistrées');
                                
                return $this->redirect($this->generateUrl('SAB_liste_mot'));
            }
        }
        
        return $this->render('SOFFTAnglaisBundle:Mot:view.html.twig', array('form' => $form->createView(), 'mot' => $mot));
    }
    
    
    public function listeMotCadenasAction(){
        $em = $this->getDoctrine()->getEntityManager();
        
        $date = new \DateTime();
        $date->sub(new \DateInterval(Mot::DUREE_CADENAS_INTERVAL));
        
        $q = $em->createQuery("SELECT m from SOFFTAnglaisBundle:Mot m 
            where m.cadenas > :date");
        $q->setParameter('date', $date);
        
        $mots = $q->getResult();
        
        $r = array();
        if (count($mots) > 0) {
            foreach ($mots as $mot){
                $r[] = array('id' => $mot->getId(), 'user' => $mot->getCadenasWho()->getUsername());
            }
        }
        
        $jsonencoder = new JsonEncoder();
        $response = new Response( $jsonencoder->encode($r, 'json') );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
        
    }
    
    public function refreshCadenasAction($motId) {
        $em = $this->getDoctrine()->getEntityManager();
        
        $mot = $em->getRepository('SOFFTAnglaisBundle:Mot')->find($motId);
        
        if ($mot == NULL) 
        {
            throw $this->createNotFoundException("Le mot demandé n'existe pas");
        }
        
        $user = $this->get('security.context')->getToken()->getUser();
        
        $mot->cadenas($user);
        $em->flush();
        
        $r['result'] = true;
        
        $jsonencoder = new JsonEncoder();
        $response = new Response( $jsonencoder->encode($r, 'json') );
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}


