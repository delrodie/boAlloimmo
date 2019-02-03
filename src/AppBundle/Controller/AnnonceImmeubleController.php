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
     * @Route("/{id}", name="backend_annonceimmeuble_show")
     * @Method("GET")
     */
    public function showAction(AnnonceImmeuble $annonceImmeuble)
    { //dump($annonceImmeuble->getAnnoncebien());die();

        return $this->render('annonceimmeuble/show.html.twig',[
            'annonceImmeuble' => $annonceImmeuble,
        ]);
    }

    /**
     * Displays a form to edit an existing immeuble entity.
     *
     * @Route("/{id}/edit/{annoncebien}", name="backend_annonceimmeuble_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnnonceImmeuble $annonceImmeuble, $annoncebien)
    {
        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:AnnonceBien')->findOneBy(array('slug' => $annoncebien));

        $editForm = $this->createForm('AppBundle\Form\AnnonceImmeubleType', $annonceImmeuble, array('bien' => $bien->getSlug()));
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush(); //dump($annoncebien);die();

            return $this->redirectToRoute('backend_annonceimmeuble_show', array('id' => $annonceImmeuble->getId(), 'slug' => $annoncebien));
        }

        return $this->render('annonceimmeuble/edit.html.twig', array(
            'immeuble' => $annonceImmeuble,
            'edit_form' => $editForm->createView(),
        ));
    }


}
