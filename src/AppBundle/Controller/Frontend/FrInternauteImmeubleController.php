<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Utils\Gestionannonce;
use AppBundle\Utils\Gestionbien;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Entity\AnnonceBien;
use AppBundle\Utils\Utilities;
use AppBundle\Entity\AnnonceImmeuble;

/**
 * @Route("annonceur-immeuble")
 */
class FrInternauteImmeubleController extends Controller
{
    /**
     * Liste des annonces de l'internaute
     * 
     * @Route("/{user}{id}/{bien}", name="frontend_annonceur_immeuble_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

    }
    /**
     * 
     * @Route("/{user}{id}/{bien}/enregistrement", name="frontend_annonceur_immeuble_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, AuthorizationCheckerInterface $authChecker, Gestionannonce $gestionannonce)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));
        $bien = $request->get('bien');


        $immeuble = new AnnonceImmeuble();
        $form = $this->createForm('AppBundle\Form\Internaute\ImmeubleType', $immeuble, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $appartement = $immeuble->getAppartement();
            $etage = $immeuble->getEtage();
            $btn = $request->get('ajouter');
            $em->persist($immeuble);
            $em->flush();

            $majBien = $gestionannonce->maj($bien);

            if ($majBien){
                if ($btn){
                    return $this->redirectToRoute('gallerieannonce_new', ['annonce'=>$bien]);
                }
                return $this->redirectToRoute('frontend_annonceur_index', [
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                ]);
            }else {
                $biens = $em->getRepository('AppBundle:AnnonceBien')->findOneBy(['id' => $bien]);
                return $this->redirectToRoute('frontend_annonceur_edit', [
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                    'slug' => $biens->getSlug()
                ]);
            }
        }

        return $this->render('internaute/immeuble_new.html.twig', array(
            'utilisateur' => $utilisateur,
            'immeuble' => $immeuble,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * 
     * @Route("/{user}{id}/{bien}/modification/{immeuble}", name="frontend_annonceur_immeuble_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AuthorizationCheckerInterface $authChecker, Gestionannonce $gestionannonce)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));
        $bien = $request->get('bien');
        $immeubleID = $request->get('immeuble');

        $immeuble = $em->getRepository('AppBundle:AnnonceImmeuble')->findOneBy(array('id'=>$immeubleID)); //dump($immeuble);die();

        $form = $this->createForm('AppBundle\Form\Internaute\ImmeubleType', $immeuble, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $btn = $request->get('ajouter');
            $em->persist($immeuble);
            $em->flush(); //dump($immeuble);die('ici');

            $majBien = $gestionannonce->maj($bien);

            if ($majBien){
                if ($btn){
                    return $this->redirectToRoute('gallerieannonce_new', ['annonce'=>$bien]);
                }
                return $this->redirectToRoute('frontend_annonceur_index', [
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                ]);
            }else {
                return $this->redirectToRoute('frontend_annonceur_edit', [
                    'id' => $utilisateur->getId(),
                    'user' => $utilisateur->getUser()->getUsername(),
                    'slug' => $bien
                ]);
            }
        }

        return $this->render('internaute/immeuble_edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'immeuble' => $immeuble,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }
}
