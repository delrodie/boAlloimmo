<?php

namespace AppBundle\Controller;

use AppBundle\Entity\GallerieAnnonce;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Gallerieannonce controller.
 *
 * @Route("gallerieannonce")
 */
class GallerieAnnonceController extends Controller
{
    /**
     * Lists all gallerieAnnonce entities.
     *
     * @Route("/", name="gallerieannonce_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $gallerieAnnonces = $em->getRepository('AppBundle:GallerieAnnonce')->findAll();

        return $this->render('gallerieannonce/index.html.twig', array(
            'gallerieAnnonces' => $gallerieAnnonces,
        ));
    }

    /**
     * Creates a new gallerieAnnonce entity.
     *
     * @Route("/new/{annonce}", name="gallerieannonce_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, AuthorizationCheckerInterface $authChecker, $annonce)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));
        $annonceEntity = $em->getRepository("AppBundle:AnnonceBien")->findOneBy(['slug'=>$annonce]);
        //dump($utilisateur);die();

        $gallerieAnnonce = new Gallerieannonce();
        $form = $this->createForm('AppBundle\Form\GallerieAnnonceType', $gallerieAnnonce, ['annonce'=> $annonce]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $btn = $request->get('ajouter'); //dump($btn); die();
            $file = $gallerieAnnonce->getImageFile();

            if (!$file){
                $this->addFlash('erreur', "Veuillez ajouter une photo ou annuler l'opération");
                return $this->redirectToRoute('gallerieannonce_new', ['annonce'=>$annonce]);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($gallerieAnnonce);//dump($gallerieAnnonce);die();
            $em->flush();
            if ($btn){
                return $this->redirectToRoute('gallerieannonce_new', ['annonce'=>$annonce]);
            } else{
                return $this->redirectToRoute('frontend_internaute_annonce_show',['typebien'=>$annonceEntity->getTypebienslug(), 'slug'=>$annonceEntity->getSlug()]);
            }

            return $this->redirectToRoute('gallerieannonce_show', array('id' => $gallerieAnnonce->getId()));
        }

        return $this->render('gallerieannonce/new.html.twig', array(
            'gallerieAnnonce' => $gallerieAnnonce,
            'form' => $form->createView(),
            'utilisateur' => $utilisateur,
            'annonce' => $annonceEntity
        ));
    }

    /**
     * Finds and displays a gallerieAnnonce entity.
     *
     * @Route("/{id}", name="gallerieannonce_show")
     * @Method("GET")
     */
    public function showAction(GallerieAnnonce $gallerieAnnonce)
    {
        $deleteForm = $this->createDeleteForm($gallerieAnnonce);

        return $this->render('gallerieannonce/show.html.twig', array(
            'gallerieAnnonce' => $gallerieAnnonce,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing gallerieAnnonce entity.
     *
     * @Route("/{id}/edit", name="gallerieannonce_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AuthorizationCheckerInterface $authChecker, GallerieAnnonce $gallerieAnnonce)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));
        $annonceEntity = $em->getRepository("AppBundle:AnnonceBien")->findOneBy(['slug'=>$gallerieAnnonce->getAnnonce()->getSlug()]);
        //dump($gallerieAnnonce);die();
        $deleteForm = $this->createDeleteForm($gallerieAnnonce);
        $editForm = $this->createForm('AppBundle\Form\GallerieAnnonceType', $gallerieAnnonce,['annonce'=> $gallerieAnnonce->getAnnonce()->getSlug()]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gallerieannonce_edit', array('id' => $gallerieAnnonce->getId()));
        }

        return $this->render('gallerieannonce/edit.html.twig', array(
            'gallerieAnnonce' => $gallerieAnnonce,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'utilisateur' => $utilisateur,
            'annonce' => $annonceEntity
        ));
    }

    /**
     * Deletes a gallerieAnnonce entity.
     *
     * @Route("/{id}", name="gallerieannonce_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, GallerieAnnonce $gallerieAnnonce)
    {
        $form = $this->createDeleteForm($gallerieAnnonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce = $request->get('annonce'); //dump($annonce);die();
            $em = $this->getDoctrine()->getManager();
            $em->remove($gallerieAnnonce);
            $em->flush();
        }

        return $this->redirectToRoute('gallerieannonce_new', ['annonce'=> $annonce]);
    }

    /**
     * Creates a form to delete a gallerieAnnonce entity.
     *
     * @param GallerieAnnonce $gallerieAnnonce The gallerieAnnonce entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(GallerieAnnonce $gallerieAnnonce)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('gallerieannonce_delete', array('id' => $gallerieAnnonce->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
