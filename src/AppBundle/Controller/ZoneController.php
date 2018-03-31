<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Zone;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Zone controller.
 *
 * @Route("backend/zone")
 */
class ZoneController extends Controller
{
    /**
     * Lists all zone entities.
     *
     * @Route("/", name="admin_zone_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        //$zones = $em->getRepository('AppBundle:Zone')->findAll();
        $zones = $em->getRepository('AppBundle:Zone')->getListeAsc();

        return $this->render('zone/index.html.twig', array(
            'zones' => $zones,
        ));
    }

    /**
     * Creates a new zone entity.
     *
     * @Route("/new", name="admin_zone_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $zone = new Zone();
        $form = $this->createForm('AppBundle\Form\ZoneType', $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($zone);
            $em->flush();

            return $this->redirectToRoute('admin_zone_index');
        }

        return $this->render('zone/new.html.twig', array(
            'zone' => $zone,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a zone entity.
     *
     * @Route("/{id}", name="admin_zone_show")
     * @Method("GET")
     */
    public function showAction(Zone $zone)
    {
        $deleteForm = $this->createDeleteForm($zone);

        return $this->render('zone/show.html.twig', array(
            'zone' => $zone,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing zone entity.
     *
     * @Route("/{id}/edit", name="admin_zone_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Zone $zone)
    {
        $deleteForm = $this->createDeleteForm($zone);
        $editForm = $this->createForm('AppBundle\Form\ZoneType', $zone);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_zone_index');
        }

        return $this->render('zone/edit.html.twig', array(
            'zone' => $zone,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a zone entity.
     *
     * @Route("/{id}", name="admin_zone_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Zone $zone)
    {
        $form = $this->createDeleteForm($zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($zone);
            $em->flush();
        }

        return $this->redirectToRoute('admin_zone_index');
    }

    /**
     * Creates a form to delete a zone entity.
     *
     * @param Zone $zone The zone entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Zone $zone)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_zone_delete', array('id' => $zone->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
