<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnnonceVilla;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Annoncevilla controller.
 *
 * @Route("backend/annoncevilla")
 */
class AnnonceVillaController extends Controller
{
    /**
     * Lists all annonceVilla entities.
     *
     * @Route("/", name="backend_annoncevilla_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $annonceVillas = $em->getRepository('AppBundle:AnnonceVilla')->findAll();

        return $this->render('annoncevilla/index.html.twig', array(
            'annonceVillas' => $annonceVillas,
        ));
    }

    /**
     * Creates a new annonceVilla entity.
     *
     * @Route("/new/{annoncebien}", name="backend_annoncevilla_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $annonceVilla = new Annoncevilla();
        $annonceBien = $request->get('annoncebien');
        $form = $this->createForm('AppBundle\Form\AnnonceVillaType', $annonceVilla, ['bien'=> $annonceBien]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonceVilla);
            $em->flush();

            return $this->redirectToRoute('backend_annoncevilla_show', array('id' => $annonceVilla->getId()));
        }

        return $this->render('annoncevilla/new.html.twig', array(
            'annonceVilla' => $annonceVilla,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a annonceVilla entity.
     *
     * @Route("/{id}", name="backend_annoncevilla_show")
     * @Method("GET")
     */
    public function showAction(AnnonceVilla $annonceVilla)
    {
        $deleteForm = $this->createDeleteForm($annonceVilla);

        return $this->render('annoncevilla/show.html.twig', array(
            'annonceVilla' => $annonceVilla,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing annonceVilla entity.
     *
     * @Route("/{id}/edit/{annoncebien}", name="backend_annoncevilla_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnnonceVilla $annonceVilla, $annoncebien)
    {
        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:AnnonceBien')->findOneBy(['slug'=>$annoncebien]);
        $deleteForm = $this->createDeleteForm($annonceVilla);
        $editForm = $this->createForm('AppBundle\Form\AnnonceVillaType', $annonceVilla, ['bien'=> $bien->getId()]);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush(); //dump($bien->getSlug());die();

            return $this->redirectToRoute('backend_annoncebien_show', array('slug' => $bien->getSlug()));
        }

        return $this->render('annoncevilla/edit.html.twig', array(
            'annonceVilla' => $annonceVilla,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a annonceVilla entity.
     *
     * @Route("/{id}", name="backend_annoncevilla_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnnonceVilla $annonceVilla)
    {
        $form = $this->createDeleteForm($annonceVilla);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonceVilla);
            $em->flush();
        }

        return $this->redirectToRoute('backend_annoncevilla_index');
    }

    /**
     * Creates a form to delete a annonceVilla entity.
     *
     * @param AnnonceVilla $annonceVilla The annonceVilla entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnnonceVilla $annonceVilla)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_annoncevilla_delete', array('id' => $annonceVilla->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
