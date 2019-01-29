<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Autrebien;
use AppBundle\Entity\Bien;
use AppBundle\Utils\Gestionbien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Autrebien controller.
 *
 * @Route("backend/autrebien")
 */
class AutrebienController extends Controller
{
    /**
     * Lists all autrebien entities.
     *
     * @Route("/", name="backend_autrebien_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $autrebiens = $em->getRepository('AppBundle:Autrebien')->findAll();

        return $this->render('autrebien/index.html.twig', array(
            'autrebiens' => $autrebiens,
        ));
    }

    /**
     * Creates a new autrebien entity.
     *
     * @Route("/new/{bien}", name="backend_autrebien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, $bien)
    {
        $autrebien = new Autrebien();
        $form = $this->createForm('AppBundle\Form\AutrebienType', $autrebien, array('bien' => $bien));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($autrebien);
            $em->flush();

            return $this->redirectToRoute('backend_autrebien_show', array('id' => $autrebien->getId(), 'bien' =>$autrebien->getBien()->getSlug()));
        }

        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('id' => $bien));

        return $this->render('autrebien/new.html.twig', array(
            'autrebien' => $autrebien,
            'form' => $form->createView(),
            'bien'  => $bien,
        ));
    }

    /**
     * Finds and displays a autrebien entity.
     *
     * @Route("/{id}/{bien}", name="backend_autrebien_show")
     * @Method("GET")
     */
    public function showAction(Autrebien $autrebien)
    {
        $deleteForm = $this->createDeleteForm($autrebien);

        $em = $this->getDoctrine()->getManager();

        $photos = $em->getRepository('AppBundle:Galleriebien')->findBy(array('bien' => $autrebien->getBien()->getId()));

        return $this->render('autrebien/show.html.twig', array(
            'autrebien' => $autrebien,
            'delete_form' => $deleteForm->createView(),
            'photos'    => $photos,
        ));
    }

    /**
     * Displays a form to edit an existing autrebien entity.
     *
     * @Route("/{id}/edit/{bien}", name="backend_autrebien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Autrebien $autrebien, $bien)
    {
        $em = $this->getDoctrine()->getManager();
        $bienEntity = $em->getRepository('AppBundle:Bien')->findOneBy(array('slug' => $bien));

        $deleteForm = $this->createDeleteForm($autrebien);
        $editForm = $this->createForm('AppBundle\Form\AutrebienType', $autrebien, array('bien' => $bienEntity->getId()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_autrebien_show', array('id' => $autrebien->getId(), 'bien' =>$autrebien->getBien()->getSlug()));
        }

        return $this->render('autrebien/edit.html.twig', array(
            'bien' => $bienEntity,
            'autrebien' => $autrebien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a autrebien entity.
     *
     * @Route("/{id}", name="backend_autrebien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Autrebien $autrebien, Gestionbien $gestionbien)
    {
        $form = $this->createDeleteForm($autrebien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $bien = $autrebien->getBien()->getId();

            $em->remove($autrebien);
            $em->flush();

            $suppressionBien = $gestionbien->suppression($bien);

            if ($suppressionBien){
                return $this->redirectToRoute('backend_bien_index');
            }else{
                $message = "Le bien concerné n'a pas été trouvé!";
                return $this->render('backend/404.html.twig',['message'=> $message]);
            }
        }

        return $this->redirectToRoute('backend_autrebien_index');
    }

    /**
     * Creates a form to delete a autrebien entity.
     *
     * @param Autrebien $autrebien The autrebien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Autrebien $autrebien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_autrebien_delete', array('id' => $autrebien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
