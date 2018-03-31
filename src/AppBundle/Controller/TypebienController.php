<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Typebien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Typebien controller.
 *
 * @Route("backend/typebien")
 */
class TypebienController extends Controller
{
    /**
     * Lists all typebien entities.
     *
     * @Route("/", name="admin_typebien_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$typebiens = $em->getRepository('AppBundle:Typebien')->findAll();
        $typebiens = $em->getRepository('AppBundle:Typebien')->getListeAsc();

        return $this->render('typebien/index.html.twig', array(
            'typebiens' => $typebiens,
        ));
    }

    /**
     * Creates a new typebien entity.
     *
     * @Route("/new", name="admin_typebien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $typebien = new Typebien();
        $form = $this->createForm('AppBundle\Form\TypebienType', $typebien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typebien);
            $em->flush();

            return $this->redirectToRoute('admin_typebien_index');
        }

        return $this->render('typebien/new.html.twig', array(
            'typebien' => $typebien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a typebien entity.
     *
     * @Route("/{id}", name="admin_typebien_show")
     * @Method("GET")
     */
    public function showAction(Typebien $typebien)
    {
        $deleteForm = $this->createDeleteForm($typebien);

        return $this->render('typebien/show.html.twig', array(
            'typebien' => $typebien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing typebien entity.
     *
     * @Route("/{id}/edit", name="admin_typebien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Typebien $typebien)
    {
        $deleteForm = $this->createDeleteForm($typebien);
        $editForm = $this->createForm('AppBundle\Form\TypebienType', $typebien);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_typebien_index');
        }

        return $this->render('typebien/edit.html.twig', array(
            'typebien' => $typebien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a typebien entity.
     *
     * @Route("/{id}", name="admin_typebien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Typebien $typebien)
    {
        $form = $this->createDeleteForm($typebien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typebien);
            $em->flush();
        }

        return $this->redirectToRoute('admin_typebien_index');
    }

    /**
     * Creates a form to delete a typebien entity.
     *
     * @param Typebien $typebien The typebien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Typebien $typebien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_typebien_delete', array('id' => $typebien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
