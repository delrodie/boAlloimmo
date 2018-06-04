<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Base controller.
 *
 * @Route("recherche")
 */
class FRechercheController extends Controller
{
    /**
     * Affichage du formulaire de recherche
     *
     * @Route("/", name="rfrontend_principale")
     */
    public function rechercheAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typebiens = $em->getRepository('AppBundle:Typebien')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $zones = $em->getRepository('AppBundle:Zone')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $services = $em->getRepository('AppBundle:Service')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $modes = $em->getRepository('AppBundle:Mode')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));

        return $this->render('frontend/recherche_formulaire.html.twig',[
            'typebiens' => $typebiens,
            'zones' => $zones,
            'services' => $services,
            'modes' => $modes,
        ]);

    }

    /**
     * Requête de recherche du service par le formulaire
     *
     * @Route("/services/", name="rfrontend_service")
     * @Method({"GET", "POST"})
     */
    public function serviceAction(Request $request)
    {
        $getService = $request->get('service');

        $em = $this->getDoctrine()->getManager();

        if ($getService){
            $service = $em->getRepository('AppBundle:Service')->findOneBy(array('libelle' => $getService));

            return $this->redirectToRoute('fannuaire_liste_partenaires', [
                'domaine'   => $service->getDomaine()->getSlug(),
                'slug'      => $service->getSlug(),
                'page'      => null,
            ]);

            dump($service);die();
        }else {
            return $this->redirectToRoute('frontend_annuaire');
        }


    }
}
