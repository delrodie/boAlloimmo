<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Utilisateur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("profile")
 */
class FrProfileController extends Controller
{
    /**
     * http://localhost:8000/register/confirmed
     * 
     * @Route("/enregistrement", name="frontend_profile_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $verifExistenceUser = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));

        if ($verifExistenceUser) { //dump( $user->getUsername()); die();
            return $this->redirectToRoute('frontend_profile_show', [
                'id' => $verifExistenceUser->getId(),
                'user' => $verifExistenceUser->getUser()->getUsername(),
            ]);
        }


        $utilisateur = new Utilisateur();
        $form = $this->createForm('AppBundle\Form\Internaute\ProfileType', $utilisateur, array('user' => $user->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('frontend_profile_show', [
                'id' => $utilisateur->getId(),
                'user' => $utilisateur->getUser()->getUsername(),
            ]);
        }

        return $this->render('internaute/_save.html.twig', array(
            'utilisateur' => $utilisateur,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{user}{id}", name="frontend_profile_show")
     * @Method("GET")
     */
    public function showAction(Utilisateur $utilisateur, AuthorizationCheckerInterface $authChecker)
    {

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        if (!$utilisateur) {
            return $this->redirectToRoute('frontend_profile_new');
        }
        return $this->render('internaute/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    /**
     * @Route("/{user}{id}/modifier", name="frontend_profile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur, AuthorizationCheckerInterface $authChecker)
    {

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        $user = $this->getUser();
        $form = $this->createForm('AppBundle\Form\Internaute\ProfileType', $utilisateur, array('user' => $user->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('frontend_profile_show', [
                'id' => $utilisateur->getId(),
                'user' => $utilisateur->getUser()->getUsername(),
            ]);
        }

        return $this->render('internaute/gestion.html.twig', array(
            'utilisateur' => $utilisateur,
            'type' => 'modification',
            'form' => $form->createView(),
        ));
    }
}
