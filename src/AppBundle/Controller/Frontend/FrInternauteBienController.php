<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Entity\AnnonceBien;
use AppBundle\Utils\Utilities;

/**
 * @Route("internaute")
 */
class FrInternauteBienController extends Controller
{
    /**
     * Liste des annonces de l'internaute
     * 
     * @Route("/{user}{id}", name="frontend_annonceur_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        $utilisateur = $request->get('id');

        // Test de la non existence d'un compte pur cet user
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));

        $listeBiens = $em->getRepository('AppBundle:AnnonceBien')->findListAnnonce($utilisateur);
        $biens = $this->get('knp_paginator')->paginate(
            $listeBiens,
            $request->query->get('page', 1), 10
        );

        return $this->render('internaute/annonce_list.html.twig',[
            'utilisateur' => $utilisateur,
            'biens' => $biens
        ]);

    }
    /**
     * 
     * @Route("/{user}{id}/enregistrement", name="frontend_annonceur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, AuthorizationCheckerInterface $authChecker, Utilities $utilities)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));


        //$bien = new Bien();
        $annonce = new AnnonceBien();
        $form = $this->createForm('AppBundle\Form\Internaute\AnnonceType', $annonce, array('user' => $utilisateur->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume(strip_tags($annonce->getDescription()), 103, '...', true);
            $typebienslug = $utilities->resume($annonce->getTypebien()->getSlug(), 5, '', true);
            $annonce->setResume($resume);
            $annonce->setTypebienslug($typebienslug);
            $annonce->setTags($annonce->getTitre()); //dump($annonce);die();

            $annonce->setStatut(1);

            $em->persist($annonce);
            $em->flush(); 

            if ($typebienslug === 'immeu'){
                return $this->redirectToRoute('frontend_annonceur_immeuble_new', [
                    'bien' => $annonce->getSlug(),
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername()
                ]);
            }elseif ($typebienslug === 'appar'){
                return $this->redirectToRoute('frontend_annonceur_appartement_new', [
                    'bien' => $annonce->getSlug(),
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                ]);
            }elseif ($typebienslug === 'villa'){ //dump($annonce->getSlug());die();
                return $this->redirectToRoute('frontend_annonceur_villa_new', [
                    'bien' => $annonce->getSlug(),
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                ]);
            }else{
                return $this->redirectToRoute('frontend_annonceur_autrebien_new', array(
                    'bien' => $annonce->getSlug(),
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername()
                ));
            }
        }

        return $this->render('internaute/annonce_new.html.twig', array(
            'utilisateur' => $utilisateur,
            'annonce' => $annonce,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * 
     * @Route("/{user}{id}/modification/{slug}", name="frontend_annonceur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AuthorizationCheckerInterface $authChecker, Utilities $utilities)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        $slug = $request->get('slug'); 

        // Test de la non existence d'un compte pur cet user
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));
        $annonce = $em->getRepository('AppBundle:AnnonceBien')->findOneBy(array('slug'=>$slug));

        $form = $this->createForm('AppBundle\Form\Internaute\AnnonceType', $annonce, array('user' => $utilisateur->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($annonce->getDescription(), 103, '...', true);
            $typebienslug = $utilities->resume($annonce->getTypebien()->getSlug(), 5, '', true);
            $annonce->setResume($resume);
            $annonce->setTypebienslug($typebienslug);
            $annonce->setTags($annonce->getTitre()); //dump($annonce);die();

            $em->persist($annonce);
            $em->flush(); 

            if ($typebienslug === 'immeu'){
                $immeuble = $em->getRepository('AppBundle:AnnonceImmeuble')->findOneBy(array('annoncebien' => $annonce->getId()));

                // Si l'immeuble n'existe pas donc affectation à la creation
                if (!$immeuble){
                    return $this->redirectToRoute('frontend_annonceur_immeuble_new', [
                        'bien' => $annonce->getSlug(),
                        'id' => $utilisateur->getId(),
                        'user' => $utilisateur->getUser()->getUsername()
                    ]);
                }
                return $this->redirectToRoute('frontend_annonceur_immeuble_edit', array(
                    'immeuble' => $immeuble->getId(),
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                    'bien' => $annonce->getSlug()
                ));
            }elseif ($typebienslug === 'appar'){
                $appartement = $em->getRepository('AppBundle:AnnonceAppartement')->findOneBy(array('annoncebien' => $annonce->getId()));

                // Si l'appartement n'existe pas alors affecter à la creation
                if (!$appartement){
                    return $this->redirectToRoute('frontend_annonceur_appartement_new',[
                        'bien' => $annonce->getSlug(),
                        'id' => $utilisateur->getId(),
                        'user' => $utilisateur->getUser()->getUsername(),
                    ]);
                }
                return $this->redirectToRoute('frontend_annonceur_appartement_edit', [
                    'appartement' => $appartement->getId(),
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                    'bien' => $annonce->getSlug()
                    // Si la villa n'existe pas alors affecter a la creation
                ]);
            }elseif ($typebienslug === 'villa'){ //dump($annonce->getSlug());die();
                $villa = $em->getRepository('AppBundle:AnnonceVilla')->findOneBy(array('annoncebien'=>$annonce->getId()));

                if(!$villa){
                    return $this->redirectToRoute('frontend_annonceur_villa_new', [
                        'bien' => $annonce->getSlug(),
                        'id' => $utilisateur->getId(),
                        'user' => $utilisateur->getUser()->getUsername(),
                    ]);
                }
                
                return $this->redirectToRoute('frontend_annonceur_villa_edit', [
                    'bien' => $annonce->getSlug(),
                    'id' => $utilisateur->getId(),
                    'villa' => $villa->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                ]);
            }else{
                $autrebien = $em->getRepository('AppBundle:AnnonceAutrebien')->findOneBy(array('annoncebien'=>$annonce->getId()));

                if (!$autrebien){
                    return $this->redirectToRoute('frontend_annonceur_autrebien_new',[
                        'bien' => $annonce->getSlug(),
                        'id' => $utilisateur->getId(),
                        'user' => $utilisateur->getUser()->getUsername(),
                    ]);
                }
                return $this->redirectToRoute('frontend_annonceur_autrebien_edit', array(
                    'bien' => $annonce->getSlug(),
                    'id' => $utilisateur->getId(),
                    'autrebien' => $autrebien->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                ));
            }
        }

        return $this->render('internaute/annonce_edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'annonce' => $annonce,
            'form' => $form->createView(),
        ));
    }
}
