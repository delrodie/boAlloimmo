<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Publicite;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Publicite controller.
 *
 * @Route("backend/publicite")
 */
class PubliciteController extends Controller
{
    /**
     * Lists all publicite entities.
     *
     * @Route("/", name="backend_publicite_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $publicites = $em->getRepository('AppBundle:Publicite')->findAll();

        return $this->render('publicite/index.html.twig', array(
            'publicites' => $publicites,
        ));
    }

    /**
     * Creates a new publicite entity.
     *
     * @Route("/new", name="backend_publicite_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $publicite = new Publicite();
        $form = $this->createForm('AppBundle\Form\PubliciteType', $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publicite);
            $em->flush();

            return $this->redirectToRoute('backend_publicite_show', array('slug' => $publicite->getSlug()));
        }

        return $this->render('publicite/new.html.twig', array(
            'publicite' => $publicite,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a publicite entity.
     *
     * @Route("/{slug}", name="backend_publicite_show")
     * @Method("GET")
     */
    public function showAction(Publicite $publicite)
    {
        $deleteForm = $this->createDeleteForm($publicite);

        return $this->render('publicite/show.html.twig', array(
            'publicite' => $publicite,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing publicite entity.
     *
     * @Route("/{slug}/edit", name="backend_publicite_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Publicite $publicite)
    {
        $deleteForm = $this->createDeleteForm($publicite);
        $editForm = $this->createForm('AppBundle\Form\PubliciteType', $publicite);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_publicite_show', array('slug' => $publicite->getSlug()));
        }

        return $this->render('publicite/edit.html.twig', array(
            'publicite' => $publicite,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a publicite entity.
     *
     * @Route("/{id}", name="backend_publicite_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Publicite $publicite)
    {
        $form = $this->createDeleteForm($publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($publicite);
            $em->flush();
        }

        return $this->redirectToRoute('backend_publicite_index');
    }

    /**
     * Creates a form to delete a publicite entity.
     *
     * @param Publicite $publicite The publicite entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Publicite $publicite)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_publicite_delete', array('id' => $publicite->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
