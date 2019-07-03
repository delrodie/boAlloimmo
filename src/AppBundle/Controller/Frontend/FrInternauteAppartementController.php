<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\AnnonceAppartement;
use AppBundle\Utils\Gestionannonce;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Entity\AnnonceBien;
use AppBundle\Utils\Utilities;

/**
 * @Route("annonceur-appartement")
 */
class FrInternauteAppartementController extends Controller
{
    /**
     * Liste des annonces de l'internaute
     * 
     * @Route("/{user}{id}/{bien}", name="frontend_annonceur_appartement_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

    }
    /**
     * 
     * @Route("/{user}{id}/{bien}/enregistrement", name="frontend_annonceur_appartement_new")
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


        $appartement = new AnnonceAppartement();
        $form = $this->createForm('AppBundle\Form\Internaute\AppartementType', $appartement, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $btn = $request->get('ajouter');
            $em->persist($appartement);
            $em->flush(); //dump($appartement);die('ici');

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

        return $this->render('internaute/appartement_new.html.twig', array(
            'utilisateur' => $utilisateur,
            'villa' => $appartement,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * 
     * @Route("/{user}{id}/{bien}/modification/{appartement}", name="frontend_annonceur_appartement_edit")
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
        $appartementID = $request->get('appartement');

        $appartement = $em->getRepository('AppBundle:AnnonceAppartement')->findOneBy(array('id'=>$appartementID)); //dump($appartement);die();

        $form = $this->createForm('AppBundle\Form\Internaute\AppartementType', $appartement, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $btn = $request->get('ajouter');
            $em->persist($appartement);
            $em->flush(); //dump($appartement);die('ici');

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

        return $this->render('internaute/appartement_edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'appartement' => $appartement,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }
}
