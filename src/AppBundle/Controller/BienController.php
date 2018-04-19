<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bien;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bien controller.
 *
 * @Route("backend/bien")
 */
class BienController extends Controller
{
    /**
     * Lists all bien entities.
     *
     * @Route("/", name="backend_bien_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $biens = $em->getRepository('AppBundle:Bien')->findAllDesc();

        return $this->render('bien/index.html.twig', array(
            'biens' => $biens,
        ));
    }

    /**
     * Creates a new bien entity.
     *
     * @Route("/new", name="backend_bien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $bien = new Bien();
        $form = $this->createForm('AppBundle\Form\BienType', $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $resume = $utilities->resume($bien->getDescription(), 103, '...', true);
            $bien->setResume($resume);
            $em->persist($bien);
            $em->flush();

            return $this->redirectToRoute('backend_autrebien_new', array('bien' => $bien->getId()));
        }

        return $this->render('bien/new.html.twig', array(
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bien entity.
     *
     * @Route("/{slug}", name="backend_bien_show")
     * @Method("GET")
     */
    public function showAction(Bien $bien)
    {
        $em = $this->getDoctrine()->getManager();
        $autrebien = $em->getRepository('AppBundle:Autrebien')->findOneBy(array('bien' => $bien->getId()));
        if ($autrebien){
            return $this->redirectToRoute('backend_autrebien_show', array('id' => $autrebien->getId(), 'bien' =>$bien->getSlug()));
        }
        $deleteForm = $this->createDeleteForm($bien);

        return $this->render('bien/show.html.twig', array(
            'bien' => $bien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bien entity.
     *
     * @Route("/{slug}/edit", name="backend_bien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bien $bien, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($bien);
        $editForm = $this->createForm('AppBundle\Form\BienType', $bien);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $resume = $utilities->resume($bien->getDescription(), 103, '...', true);
            $bien->setResume($resume);
            $this->getDoctrine()->getManager()->flush();

            $em = $this->getDoctrine()->getManager();
            $autrebien = $em->getRepository('AppBundle:Autrebien')->findOneBy(array('bien' => $bien->getId()));
            if ($autrebien){
                return $this->redirectToRoute('backend_autrebien_edit', array('id' => $autrebien->getId(), 'bien' =>$bien->getSlug()));
            }

            return $this->redirectToRoute('backend_bien_edit', array('slug' => $bien->getSlug()));
        }

        return $this->render('bien/edit.html.twig', array(
            'bien' => $bien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bien entity.
     *
     * @Route("/{id}", name="backend_bien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bien $bien)
    {
        $form = $this->createDeleteForm($bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bien);
            $em->flush();
        }

        return $this->redirectToRoute('backend_bien_index');
    }

    /**
     * Creates a form to delete a bien entity.
     *
     * @param Bien $bien The bien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bien $bien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_bien_delete', array('id' => $bien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
