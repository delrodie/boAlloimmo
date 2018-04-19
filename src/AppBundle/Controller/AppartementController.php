<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Appartement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Appartement controller.
 *
 * @Route("backend/appartement")
 */
class AppartementController extends Controller
{
    /**
     * Lists all appartement entities.
     *
     * @Route("/", name="backend_appartement_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $appartements = $em->getRepository('AppBundle:Appartement')->findAll();

        return $this->render('appartement/index.html.twig', array(
            'appartements' => $appartements,
        ));
    }

    /**
     * Creates a new appartement entity.
     *
     * @Route("/new/{bien}", name="backend_appartement_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $bien)
    {
        $appartement = new Appartement();
        $form = $this->createForm('AppBundle\Form\AppartementType', $appartement, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($appartement);
            $em->flush();

            return $this->redirectToRoute('backend_appartement_show', array('id' => $appartement->getId(), 'bien' => $appartement->getBien()->getSlug()));
        }

        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('id' => $bien));

        return $this->render('appartement/new.html.twig', array(
            'appartement' => $appartement,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a appartement entity.
     *
     * @Route("/{id}/{bien}", name="backend_appartement_show")
     * @Method("GET")
     */
    public function showAction(Appartement $appartement)
    {
        $deleteForm = $this->createDeleteForm($appartement);

        return $this->render('appartement/show.html.twig', array(
            'appartement' => $appartement,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing appartement entity.
     *
     * @Route("/{id}/edit/{bien}", name="backend_appartement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Appartement $appartement, $bien)
    {
        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('slug' => $bien));

        $deleteForm = $this->createDeleteForm($appartement);
        $editForm = $this->createForm('AppBundle\Form\AppartementType', $appartement, array('bien' => $bien->getId()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_appartement_show', array('id' => $appartement->getId(), 'bien' => $appartement->getBien()->getSlug()));
        }

        return $this->render('appartement/edit.html.twig', array(
            'appartement' => $appartement,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a appartement entity.
     *
     * @Route("/{id}", name="backend_appartement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Appartement $appartement)
    {
        $form = $this->createDeleteForm($appartement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($appartement);
            $em->flush();
        }

        return $this->redirectToRoute('backend_appartement_index');
    }

    /**
     * Creates a form to delete a appartement entity.
     *
     * @param Appartement $appartement The appartement entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Appartement $appartement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_appartement_delete', array('id' => $appartement->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
