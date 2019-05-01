<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontenddomaineController extends Controller
{
    /**
     * Liste des prestataires du domaine
     *
     * @Route("/categorie/{slug}", name="fannuaire_domaine_partenaire")
     */
    public function categorieAction(Request $request, $slug)
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

        $listePartenaires = $em->getRepository('AppBundle:Partenaire')->findListePartenaireByDomaine($slug); //dump($partenaires); die();
        $partenaires = $this->get('knp_paginator')->paginate(
            $listePartenaires,
            $request->query->get('page', 1), 15
        );
        $listeservices = $em->getRepository('AppBundle:Service')->findListeServiceBy($slug);
        $domaine = $em->getRepository('AppBundle:Domaine')->findOneBy(array('slug' => $slug)); //dump($domaine);die();
        $autreDomaines = $em->getRepository('AppBundle:Domaine')->findAutreDomaine($slug);
        //$service = $em->getRepository('AppBundle:Service')->findOneBy(array('domaine'=> $slug)); dump($service); die();

        $promotions = $em->getRepository('AppBundle:Bien')
            ->findBienEnPromo(0, 4);
        $domaines = $em->getRepository('AppBundle:Domaine')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $biens = $em->getRepository('AppBundle:Bien')
            ->findDernierBienEnPromo(4, 0);
        $promoBiens = $em->getRepository('AppBundle:Bien')->findListPromotion(0, 10);

        return $this->render('frontend/annuaire_domaine_prestataires.html.twig',[
            'domaine' => $domaine,
            'autreDomaines' => $autreDomaines,
            'partenaires'    => $partenaires,
            'typebiens' => $typebiens,
            'zones' => $zones,
            'services' => $services,
            //'service' => $service,
            'modes' => $modes,
            'listeservices' => $listeservices,
            'domaines' => $domaines,
            'promotions' => $promotions,
            'biens' => $biens,
            'promoBiens' => $promoBiens
        ]);
    }

}
