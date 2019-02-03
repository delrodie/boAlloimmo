<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnnonceAutrebien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AnnonceAutrebienController
 * @Route("backend/annonceautrebien")
 */
class AnnonceAutrebienController extends Controller
{
    /**
     * @Route("/{id}/{annoncebien}", name="backend_annonceautrebien_show")
     * @Method("GET")
     */
    public function showAction(AnnonceAutrebien $annonceAutrebien)
    {
        return $this->render('annonceautrebien/show.html.twig',[
            'annonceAutrebien' => $annonceAutrebien,
        ]);
    }

    /**
     * Displays a form to edit an existing autrebien entity.
     *
     * @Route("/{id}/edit/{annoncebien}", name="backend_annonceautrebien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnnonceAutrebien $annonceAutrebien, $annoncebien)
    {
        $em = $this->getDoctrine()->getManager();
        $annoncebienEntity = $em->getRepository('AppBundle:AnnonceBien')->findOneBy(array('slug' => $annoncebien));

        $editForm = $this->createForm('AppBundle\Form\AnnonceAutrebienType', $annonceAutrebien, array('bien' => $annoncebienEntity->getSlug()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('backend_annonceautrebien_show', array('id' => $annonceAutrebien->getId(), 'annoncebien' =>$annoncebien));
        }

        return $this->render('annonceautrebien/edit.html.twig', array(
            'bien' => $annoncebienEntity,
            'autrebien' => $annonceAutrebien,
            'edit_form' => $editForm->createView(),
        ));
    }

}
