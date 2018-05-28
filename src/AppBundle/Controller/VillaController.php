<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Villa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Villa controller.
 *
 * @Route("backend/villa")
 */
class VillaController extends Controller
{
    /**
     * Lists all villa entities.
     *
     * @Route("/", name="backend_villa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $villas = $em->getRepository('AppBundle:Villa')->findAll();

        return $this->render('villa/index.html.twig', array(
            'villas' => $villas,
        ));
    }

    /**
     * Creates a new villa entity.
     *
     * @Route("/new/{bien}", name="backend_villa_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $bien)
    {
        $villa = new Villa();
        $form = $this->createForm('AppBundle\Form\VillaType', $villa, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($villa);
            $em->flush();

            return $this->redirectToRoute('backend_villa_show', array('id' => $villa->getId(), 'bien' => $villa->getBien()->getSlug()));
        }

        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('id' => $bien));

        return $this->render('villa/new.html.twig', array(
            'villa' => $villa,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a villa entity.
     *
     * @Route("/{id}/{bien}", name="backend_villa_show")
     * @Method("GET")
     */
    public function showAction(Villa $villa, $bien)
    {
        $deleteForm = $this->createDeleteForm($villa);

        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('AppBundle:Galleriebien')->findBy(array('bien' => $villa->getBien()->getId()));

        return $this->render('villa/show.html.twig', array(
            'villa' => $villa,
            'delete_form' => $deleteForm->createView(),
            'photos'    => $photos,
        ));
    }

    /**
     * Displays a form to edit an existing villa entity.
     *
     * @Route("/{id}/edit/{bien}", name="backend_villa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Villa $villa, $bien)
    {
        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('slug' => $bien));

        $deleteForm = $this->createDeleteForm($villa);
        $editForm = $this->createForm('AppBundle\Form\VillaType', $villa, array('bien' => $bien->getId()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_villa_show', array('id' => $villa->getId(), 'bien' => $bien));
        }

        return $this->render('villa/edit.html.twig', array(
            'villa' => $villa,
            'bien' => $bien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a villa entity.
     *
     * @Route("/{id}", name="backend_villa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Villa $villa)
    {
        $form = $this->createDeleteForm($villa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($villa);
            $em->flush();
        }

        return $this->redirectToRoute('backend_villa_index');
    }

    /**
     * Creates a form to delete a villa entity.
     *
     * @param Villa $villa The villa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Villa $villa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_villa_delete', array('id' => $villa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
