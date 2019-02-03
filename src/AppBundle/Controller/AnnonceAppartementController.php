<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnnonceAppartement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AnnonceAppartementController
 * @Route("backend/annonceappartement")
 */
class AnnonceAppartementController extends Controller
{
    /**
     * @Route("/{id}/{annoncebien}", name="backend_annonceappartement_show")
     * @Method("GET")
     */
    public function showAction(AnnonceAppartement $annonceAppartement)
    {
        return $this->render('annonceappartement/show.html.twig',[
            'annonceAppartement' => $annonceAppartement,
        ]);
    }

    /**
     * Displays a form to edit an existing appartement entity.
     *
     * @Route("/{id}/edit/{annoncebien}", name="backend_annonceappartement_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnnonceAppartement $annonceAppartement, $annoncebien)
    {
        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:AnnonceBien')->findOneBy(['slug'=>$annoncebien]);//dump($bien);die();

        $editForm = $this->createForm('AppBundle\Form\AnnonceAppartementType', $annonceAppartement, array('bien' => $bien->getSlug()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_annonceappartement_show', array('id' => $annonceAppartement->getId(), 'annoncebien' => $annonceAppartement->getAnnoncebien()->getSlug()));
        }

        return $this->render('annonceappartement/edit.html.twig', array(
            'appartement' => $annonceAppartement,
            'edit_form' => $editForm->createView(),
        ));
    }
}
