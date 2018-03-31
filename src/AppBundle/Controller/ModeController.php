<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Mode controller.
 *
 * @Route("backend/mode")
 */
class ModeController extends Controller
{
    /**
     * Lists all mode entities.
     *
     * @Route("/", name="backend_mode_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$modes = $em->getRepository('AppBundle:Mode')->findAll();
        $modes = $em->getRepository('AppBundle:Mode')->getListeAsc();

        return $this->render('mode/index.html.twig', array(
            'modes' => $modes,
        ));
    }

    /**
     * Creates a new mode entity.
     *
     * @Route("/new", name="backend_mode_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $mode = new Mode();
        $form = $this->createForm('AppBundle\Form\ModeType', $mode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mode);
            $em->flush();

            return $this->redirectToRoute('backend_mode_index');
        }

        return $this->render('mode/new.html.twig', array(
            'mode' => $mode,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mode entity.
     *
     * @Route("/{id}", name="backend_mode_show")
     * @Method("GET")
     */
    public function showAction(Mode $mode)
    {
        $deleteForm = $this->createDeleteForm($mode);

        return $this->render('mode/show.html.twig', array(
            'mode' => $mode,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mode entity.
     *
     * @Route("/{id}/edit", name="backend_mode_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Mode $mode)
    {
        $deleteForm = $this->createDeleteForm($mode);
        $editForm = $this->createForm('AppBundle\Form\ModeType', $mode);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_mode_index');
        }

        return $this->render('mode/edit.html.twig', array(
            'mode' => $mode,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mode entity.
     *
     * @Route("/{id}", name="backend_mode_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Mode $mode)
    {
        $form = $this->createDeleteForm($mode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mode);
            $em->flush();
        }

        return $this->redirectToRoute('backend_mode_index');
    }

    /**
     * Creates a form to delete a mode entity.
     *
     * @param Mode $mode The mode entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Mode $mode)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_mode_delete', array('id' => $mode->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
