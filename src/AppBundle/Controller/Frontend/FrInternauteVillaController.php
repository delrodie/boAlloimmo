<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Utils\Gestionannonce;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use AppBundle\Entity\AnnonceBien;
use AppBundle\Utils\Utilities;
use AppBundle\Entity\AnnonceVilla;

/**
 * @Route("annonceur")
 */
class FrInternauteVillaController extends Controller
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
     * @Route("/{user}{id}/{bien}/enregistrement", name="frontend_annonceur_villa_new")
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


        $villa = new AnnonceVilla();
        $form = $this->createForm('AppBundle\Form\Internaute\VillaType', $villa, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($villa);
            $em->flush(); //dump($villa);die('ici');

            $majBien = $gestionannonce->maj($bien);

            if ($majBien){
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

        return $this->render('internaute/villa_new.html.twig', array(
            'utilisateur' => $utilisateur,
            'villa' => $villa,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * 
     * @Route("/{user}{id}/{bien}/modification/{villa}", name="frontend_annonceur_villa_edit")
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
        $villaID = $request->get('villa');

        $villa = $em->getRepository('AppBundle:AnnonceVilla')->findOneBy(array('id'=>$villaID)); //dump($villa);die();

        $form = $this->createForm('AppBundle\Form\Internaute\VillaType', $villa, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($villa);
            $em->flush(); //dump($villa);die('ici');

            $majBien = $gestionannonce->maj($bien);

            if ($majBien){
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

        return $this->render('internaute/villa_edit.html.twig', array(
            'utilisateur' => $utilisateur,
            'villa' => $villa,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }
}
