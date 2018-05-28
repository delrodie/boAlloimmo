<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Galleriebien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Galleriebien controller.
 *
 * @Route("backend/gallerie/bien")
 */
class GalleriebienController extends Controller
{
    /**
     * Lists all galleriebien entities.
     *
     * @Route("/", name="backend_galleriebien_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $galleriebiens = $em->getRepository('AppBundle:Galleriebien')->findAll();

        return $this->render('galleriebien/index.html.twig', array(
            'galleriebiens' => $galleriebiens,
        ));
    }

    /**
     * Creates a new galleriebien entity.
     *
     * @Route("/new/{bien}", name="backend_galleriebien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $bien)
    {
        $galleriebien = new Galleriebien();
        $form = $this->createForm('AppBundle\Form\GalleriebienType', $galleriebien, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($galleriebien);
            $em->flush();

            return $this->redirectToRoute('backend_galleriebien_new', array('bien' => $bien));
        }

        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('AppBundle:Galleriebien')->findBy(array('bien' => $bien), array('id' => 'DESC'));
        $retourBien = $em->getRepository('AppBundle:Bien')->findOneBy(array('id'=> $bien));

        return $this->render('galleriebien/new.html.twig', array(
            'galleriebien' => $galleriebien,
            'form' => $form->createView(),
            'photos'    => $photos,
            'retourBien'    => $retourBien,
        ));
    }

    /**
     * Finds and displays a galleriebien entity.
     *
     * @Route("/{id}", name="backend_galleriebien_show")
     * @Method("GET")
     */
    public function showAction(Galleriebien $galleriebien)
    {
        $deleteForm = $this->createDeleteForm($galleriebien);

        return $this->render('galleriebien/show.html.twig', array(
            'galleriebien' => $galleriebien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing galleriebien entity.
     *
     * @Route("/{id}/edit/{bien}", name="backend_galleriebien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Galleriebien $galleriebien, $bien)
    {
        $deleteForm = $this->createDeleteForm($galleriebien);
        $editForm = $this->createForm('AppBundle\Form\GalleriebienType', $galleriebien, array('bien' => $bien));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_galleriebien_new', array('bien' => $bien));
        }

        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('AppBundle:Galleriebien')->findBy(array('bien' => $bien), array('id' => 'DESC'));
        $retourBien = $em->getRepository('AppBundle:Bien')->findOneBy(array('id'=> $bien));

        return $this->render('galleriebien/edit.html.twig', array(
            'galleriebien' => $galleriebien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'photos'    => $photos,
            'retourBien'    => $retourBien,
        ));
    }

    /**
     * Deletes a galleriebien entity.
     *
     * @Route("/{id}", name="backend_galleriebien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Galleriebien $galleriebien)
    {
        $form = $this->createDeleteForm($galleriebien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($galleriebien);
            $em->flush();
        }

        return $this->redirectToRoute('backend_bien_index');
    }

    /**
     * Creates a form to delete a galleriebien entity.
     *
     * @param Galleriebien $galleriebien The galleriebien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Galleriebien $galleriebien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_galleriebien_delete', array('id' => $galleriebien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
