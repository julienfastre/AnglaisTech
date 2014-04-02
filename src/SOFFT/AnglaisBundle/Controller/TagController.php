<?php

namespace SOFFT\AnglaisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TagController extends Controller
{
    public function listAction() {
        $tags = $this->getDoctrine()->getManager()
                ->getRepository('SOFFTAnglaisBundle:Tag')
                ->findAll();
        
        return $this->render('SOFFTAnglaisBundle:Tag:list.html.twig', array(
            'tags' => $tags
        ));
    }
    
    public function createAction(Request $request) {
        $tag = new \SOFFT\AnglaisBundle\Entity\Tag();
        
        $form = $this->createForm(new \SOFFT\AnglaisBundle\Form\TagType(), $tag);
        
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($tag);
                $em->flush();
                
                $this->get('session')->getFlashBag()
                        ->set('notice', "L'étiquette a été créée");
                
                return $this->redirect($this->generateUrl('SAB_tag_liste'));
            } else {
                $this->get('session')->getFlashBag()
                        ->set('warning', "Erreur dans la création de l'étiquette !");
            }
        }
        
        
        return $this->render('SOFFTAnglaisBundle:Tag:form.html.twig', array(
            'form' => $form->createView()
        ));
    }
    
    public function updateAction(Request $request, $id) {
        $tag = $this->getDoctrine()->getManager()
                ->getRepository('SOFFTAnglaisBundle:Tag')
                ->find($id);
        
        if ($tag === NULL) {
            return $this->createNotFoundException("L'étiquette n'a pas été trouvée !");
        }
        
        $form = $this->createForm(new \SOFFT\AnglaisBundle\Form\TagType(), $tag);
        
        
        if ($request->getMethod() === 'POST') {
            $form->handleRequest($request);
            
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($tag);
                $em->flush();
                
                $this->get('session')->getFlashBag()
                        ->set('notice', "L'étiquette a été modifiée");
                
                return $this->redirect($this->generateUrl('SAB_tag_liste'));
            } else {
                $this->get('session')->getFlashBag()
                        ->set('warning', "Erreur dans la création de l'étiquette !");
            }
        }
        
        
        return $this->render('SOFFTAnglaisBundle:Tag:form.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
