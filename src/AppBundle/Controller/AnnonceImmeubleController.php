<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnnonceImmeuble;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("backend/annonceimmeuble")
 */
class AnnonceImmeubleController extends Controller
{
    /**
     * @Route("/{slug}", name="backend_annonceimmeuble_show")
     * @Method("GET")
     */
    public function showAction(AnnonceImmeuble $annonceImmeuble)
    {
        $deleteForm = $this->createDeleteForm($annonceImmeuble);

        return $this->render('annonceimmeuble/show.html.twig',[
            'annonceImmeuble' => $annonceImmeuble,
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="backend_annonceimmeuble_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnnonceImmeuble $annonceImmeuble)
    {
        $form = $this->createDeleteForm($annonceImmeuble);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonceImmeuble);
            $em->flush();
        }

        return $this->redirectToRoute('backend_annoncebien_index');
    }

    /**
     * Cration du formulaire de suppression
     *
     * @param AnnonceImmeuble $annonceImmeuble
     *
     * @return \Symfony\Component\Form\Form
     */
    private function createDeleteForm(AnnonceImmeuble $annonceImmeuble)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_annonceimmeuble_delete', ['id'=> $annonceImmeuble]))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}