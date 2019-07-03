<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\AnnonceAutrebien;
use AppBundle\Utils\Gestionannonce;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("annonceur-autrebien")
 */
class FrInternauteAutrebienController extends Controller
{
    /**
     * Liste des annonces de l'internaute
     * 
     * @Route("/{user}{id}/{bien}", name="frontend_annonceur_villa_index")
     * @Method({"GET", "POST"})
     */
    public function indexAction()
    {

    }
    /**
     * 
     * @Route("/{user}{id}/{bien}/enregistrement", name="frontend_annonceur_autrebien_new")
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


        $autrebien = new AnnonceAutrebien();
        $form = $this->createForm('AppBundle\Form\Internaute\AutrebienType', $autrebien, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $btn = $request->get('ajouter');
            $em->persist($autrebien);
            $em->flush(); //dump($villa);die('ici');

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

        return $this->render('internaute/autrebien_new.html.twig', array(
            'utilisateur' => $utilisateur,
            'autrebien' => $autrebien,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * 
     * @Route("/{user}{id}/{bien}/modification/{autrebien}", name="frontend_annonceur_autrebien_edit")
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
        $autrebienID = $request->get('autrebien');

        $autrebien = $em->getRepository('AppBundle:AnnonceAutrebien')->findOneBy(array('id'=>$autrebienID)); //dump($autrebien);die();

        $form = $this->createForm('AppBundle\Form\Internaute\AutrebienType', $autrebien, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $btn = $request->get('ajouter');
            $em->persist($autrebien);
            $em->flush(); //dump($autrebien);die('ici');

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

        return $this->render('internaute/autrebien_edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'autrebien' => $autrebien,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }
}
