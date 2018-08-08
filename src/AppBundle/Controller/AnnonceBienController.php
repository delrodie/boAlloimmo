<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnnonceBien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Annoncebien controller.
 *
 * @Route("backend/annoncebien")
 */
class AnnonceBienController extends Controller
{
    /**
     * Lists all annonceBien entities.
     *
     * @Route("/", name="backend_annoncebien_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $annonceBiens = $em->getRepository('AppBundle:AnnonceBien')->findAll();

        return $this->render('annoncebien/index.html.twig', array(
            'annonceBiens' => $annonceBiens,
        ));
    }

    /**
     * Creates a new annonceBien entity.
     *
     * @Route("/new", name="backend_annoncebien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $annonceBien = new Annoncebien();
        $form = $this->createForm('AppBundle\Form\AnnonceBienType', $annonceBien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonceBien);
            $em->flush();

            return $this->redirectToRoute('backend_annoncebien_show', array('id' => $annonceBien->getId()));
        }

        return $this->render('annoncebien/new.html.twig', array(
            'annonceBien' => $annonceBien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a annonceBien entity.
     *
     * @Route("/{id}", name="backend_annoncebien_show")
     * @Method("GET")
     */
    public function showAction(AnnonceBien $annonceBien)
    {
        $deleteForm = $this->createDeleteForm($annonceBien);

        return $this->render('annoncebien/show.html.twig', array(
            'annonceBien' => $annonceBien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing annonceBien entity.
     *
     * @Route("/{id}/edit", name="backend_annoncebien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnnonceBien $annonceBien)
    {
        $deleteForm = $this->createDeleteForm($annonceBien);
        $editForm = $this->createForm('AppBundle\Form\AnnonceBienType', $annonceBien);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_annoncebien_edit', array('id' => $annonceBien->getId()));
        }

        return $this->render('annoncebien/edit.html.twig', array(
            'annonceBien' => $annonceBien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a annonceBien entity.
     *
     * @Route("/{id}", name="backend_annoncebien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnnonceBien $annonceBien)
    {
        $form = $this->createDeleteForm($annonceBien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonceBien);
            $em->flush();
        }

        return $this->redirectToRoute('backend_annoncebien_index');
    }

    /**
     * Creates a form to delete a annonceBien entity.
     *
     * @param AnnonceBien $annonceBien The annonceBien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnnonceBien $annonceBien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_annoncebien_delete', array('id' => $annonceBien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
