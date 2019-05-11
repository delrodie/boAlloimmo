<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Base controller.
 *
 * @Route("annuaire")
 */
class FrontendannuaireController extends Controller
{
    /**
     * Liste des services selon le domaine
     *
     * @Route("/", name="frontend_annuaire")
     */
    public function annuaireAction()
    {
        $em = $this->getDoctrine()->getManager();

        $biens = $em->getRepository('AppBundle:Bien')
            ->findDernierBienEnPromo(6, 0);

        $promotions = $em->getRepository('AppBundle:Bien')
            ->findListPromotion(0, 10);

        $domaines = $em->getRepository('AppBundle:Domaine')
            ->findBy(array('statut' => 1), array('ordre' => 'ASC'));

        return $this->render("frontend/annuaire.html.twig", [
            'domaines' => $domaines,
            //'pagination'    => $pagination,
            'biens' => $biens,
            'promotions' => $promotions,
        ]);

    }

    /**
     * Liste des services selon le domaine
     *
     * @Route("/{domaine}/domaine", name="fannuaire_domaine")
     */
    public function domaineAction($domaine)
    {
        $em = $this->getDoctrine()->getManager();
        $services = $em->getRepository('AppBundle:Service')
             ->findBy(array('domaine' => $domaine), array('libelle' => 'ASC'), 5, 0)
            ;//dump($services);die();

        return $this->render('frontend/annuaire_service.html.twig',[
            'services' => $services,
        ]);
    }

    /**
     * Nombre de services par domaine
     *
     * @Route("/domaine/compteur/{domaine}", name="fannuaire_compteur_service")
     */
    public function compteurAction($domaine)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre = $em->getRepository('AppBundle:Service')
            ->findBy(array('domaine' => $domaine), array('libelle' => 'ASC'), 5, 5)
        ;//dump($nombre);die();
        $domaines = $em->getRepository('AppBundle:Domaine')->findOneBy(array('id'=>$domaine));

        return $this->render("frontend/annuaire_autreservice.html.twig",[
            'nombre' => $nombre,
            'domaine' => $domaines,
        ]);
    }

    /**
     * Nombre de partenaires par service
     *
     * @Route("/nombre-partenaire-du-service-{service}", name="fnombre_partenaire_service")
     */
    public function nombrepartenaireAction($service)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre = $em->getRepository('AppBundle:Service')->cpteurPartenaire($service); //dump($nombre);die();

        return new Response($nombre);

    }

    /**
     * Nombre de partenaires par domaine
     *
     * @Route("/{domaine}", name="fnombre_partenaire_domaine")
     */
    public function nombrepartenairedomaineAction($domaine)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre = $em->getRepository('AppBundle:Service')->cpteurDomainePartenaire($domaine); //dump($nombre);die();

        return new Response($nombre);

    }

    /**
     * Liste des prestataires du service
     *
     * @Route("/{domaine}/{slug}/", name="fannuaire_liste_partenaires")
     */
    public function listeAction($domaine, $slug, Request $request)
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

        $listePartenaires = $em->getRepository('AppBundle:Partenaire')->findListePartenaireBy($slug);
        $partenaires = $this->get('knp_paginator')->paginate(
            $listePartenaires,
            $request->query->get('page', 1), 5
        );//dump($partenaires); die();

        $listeservices = $em->getRepository('AppBundle:Service')->findListeServiceBy($domaine);
        $domaine = $em->getRepository('AppBundle:Domaine')->findOneBy(array('slug' => $domaine));
        $autreDomaines = $em->getRepository('AppBundle:Domaine')->findAutreDomaine($domaine);
        $service = $em->getRepository('AppBundle:Service')->findOneBy(array('slug'=> $slug));

        $promotions = $em->getRepository('AppBundle:Bien')
            ->findBienEnPromo(0, 4);
        $domaines = $em->getRepository('AppBundle:Domaine')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $biens = $em->getRepository('AppBundle:Bien')
            ->findDernierBienEnPromo(4, 0);
        $promoBiens = $em->getRepository('AppBundle:Bien')->findListPromotion(0, 10);

        return $this->render('frontend/annuaire_liste_prestataires.html.twig',[
            'domaine' => $domaine,
            'autreDomaines' => $autreDomaines,
            'partenaires'    => $partenaires,
            'typebiens' => $typebiens,
            'zones' => $zones,
            'services' => $services,
            'service' => $service,
            'modes' => $modes,
            'listeservices' => $listeservices,
            'domaines' => $domaines,
            'promotions' => $promotions,
            'biens' => $biens,
            'promoBiens' => $promoBiens
        ]);
    }

    /**
     * Affichage du partenaire
     *
     * @Route("/{domaine}/{service}/{annee}/{slug}", name="fannuaire_partenaire")
     */
    public function partenaireAction(Request $request, $domaine, $service, $slug)
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

        $domaine = $em->getRepository('AppBundle:Domaine')->findOneBy(array('slug' => $domaine));
        $service = $em->getRepository('AppBundle:Service')->findOneBy(array('slug'=> $service));
        $partenaire = $em->getRepository('AppBundle:Partenaire')->findOneBy(array('slug'=> $slug));

        $promotions = $em->getRepository('AppBundle:Bien')
            ->findBienEnPromo(0, 4);
        $listeBiens = $em->getRepository('AppBundle:Bien')
            ->findBienPartenaire($slug);
        $biens = $this->get('knp_paginator')->paginate(
            $listeBiens,
            $request->query->get('page', 1), 9
        );

        return $this->render('frontend/annuaire_partenaire.html.twig',[
            'domaine' => $domaine,
            'typebiens' => $typebiens,
            'zones' => $zones,
            'services' => $services,
            'service' => $service,
            'modes' => $modes,
            'promotions' => $promotions,
            'biens' => $biens,
            'partenaire' => $partenaire,
            'service' => $service,
        ]);
    }

}
