<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Immeuble;
use AppBundle\Utils\Gestionbien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Immeuble controller.
 *
 * @Route("backend/immeuble")
 */
class ImmeubleController extends Controller
{
    /**
     * Lists all immeuble entities.
     *
     * @Route("/", name="backend_immeuble_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $immeubles = $em->getRepository('AppBundle:Immeuble')->findAll();

        return $this->render('immeuble/index.html.twig', array(
            'immeubles' => $immeubles,
        ));
    }

    /**
     * Creates a new immeuble entity.
     *
     * @Route("/new/{bien}", name="backend_immeuble_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $bien)
    {
        $immeuble = new Immeuble();
        $form = $this->createForm('AppBundle\Form\ImmeubleType', $immeuble, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($immeuble);
            $em->flush();

            return $this->redirectToRoute('backend_immeuble_show', array('id' => $immeuble->getId(), 'bien' => $immeuble->getBien()->getSlug()));
        }

        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('id' => $bien));

        return $this->render('immeuble/new.html.twig', array(
            'immeuble' => $immeuble,
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a immeuble entity.
     *
     * @Route("/{id}/{bien}", name="backend_immeuble_show")
     * @Method("GET")
     */
    public function showAction(Immeuble $immeuble)
    {
        $deleteForm = $this->createDeleteForm($immeuble);

        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('AppBundle:Galleriebien')->findBy(array('bien' => $immeuble->getBien()->getId()));

        return $this->render('immeuble/show.html.twig', array(
            'immeuble' => $immeuble,
            'delete_form' => $deleteForm->createView(),
            'photos'    => $photos,
        ));
    }

    /**
     * Displays a form to edit an existing immeuble entity.
     *
     * @Route("/{id}/edit/{bien}", name="backend_immeuble_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Immeuble $immeuble, $bien)
    {
        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('slug' => $bien));

        $deleteForm = $this->createDeleteForm($immeuble);
        $editForm = $this->createForm('AppBundle\Form\ImmeubleType', $immeuble, array('bien' => $bien->getId()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_immeuble_show', array('id' => $immeuble->getId(), 'bien' => $immeuble->getBien()->getSlug()));
        }

        return $this->render('immeuble/edit.html.twig', array(
            'immeuble' => $immeuble,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a immeuble entity.
     *
     * @Route("/{id}", name="backend_immeuble_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Immeuble $immeuble, Gestionbien $gestionbien)
    {
        $form = $this->createDeleteForm($immeuble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $bien = $immeuble->getBien()->getId();
            $em->remove($immeuble);
            $em->flush();

            $suppressionBien = $gestionbien->suppression($bien);

            if ($suppressionBien){
                return $this->redirectToRoute('backend_bien_index');
            }else{
                $message = "Le bien concerné n'a pas été trouvé!";
                return $this->render('backend/404.html.twig',['message'=> $message]);
            }
        }

        return $this->redirectToRoute('backend_immeuble_index');
    }

    /**
     * Creates a form to delete a immeuble entity.
     *
     * @param Immeuble $immeuble The immeuble entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Immeuble $immeuble)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_immeuble_delete', array('id' => $immeuble->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
