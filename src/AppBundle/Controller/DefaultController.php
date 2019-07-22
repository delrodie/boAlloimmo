<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $sliders = $em->getRepository('AppBundle:Slider')
                        ->findBy(array('statut' => 1), array('id' => 'DESC'), 4, 0);
        $typebiens = $em->getRepository('AppBundle:Typebien')
                        ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $zones = $em->getRepository('AppBundle:Zone')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $services = $em->getRepository('AppBundle:Service')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $modes = $em->getRepository('AppBundle:Mode')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $domaines = $em->getRepository('AppBundle:Domaine')
            ->findBy(array('statut' => 1), array('ordre' => 'ASC'));
        $biens = $em->getRepository('AppBundle:Bien')->findListPromotion(0, 10);
        $articleServices = $em->getRepository('AppBundle:Article')
            ->findArticleByRubrique($slug = 'service', $offset = 0, $limit = 3);
        $articlePresentations = $em->getRepository('AppBundle:Article')
            ->findArticleByRubrique($slug = 'somme', $offset = 0, $limit = 1);
        $articleConseils = $em->getRepository('AppBundle:Article')
            ->findArticleByRubrique($slug = 'conseil', $offset = 0, $limit = 4); //dump($biens);die();
        $faqs = $em->getRepository('AppBundle:Faq')
            ->findBy(array('statut' => 1), array('id' => 'ASC'));
        $promotions = $em->getRepository('AppBundle:Bien')->findBienEnPromo(0,1);
        $publicites = $em->getRepository('AppBundle:Publicite')->findPubliciteEncours(0,4);
        //dump(date('H:i', time()));die();

        return $this->render('default/index.html.twig', [
            'sliders' => $sliders,
            'typebiens' => $typebiens,
            'zones' => $zones,
            'services' => $services,
            'modes' => $modes,
            'domaines' => $domaines,
            'biens' => $biens,
            'articleServices' => $articleServices,
            'articlePresentations' => $articlePresentations,
            'articleConseils' => $articleConseils,
            'faqs' => $faqs,
            'promotions' => $promotions,
            'publicites' => $publicites,
        ]);
    }

    /**
     * Liste des actions du mouchard non lues
     * @Route("/mouchard", name="mouchard")
     */
    public function mouchardAction()
    {
        $em = $this->getDoctrine()->getManager();
        $mouchards = $em->getRepository('AppBundle:Mouchard')->findBy(['flag'=>null],['createdAt'=>'DESC'], 5, 0);
        $nombreNonLu = $em->getRepository('AppBundle:Mouchard')->findNonLu();
        //dump($nombreNonLu);die();
        return $this->render('backend/mouchard.html.twig',[
            'mouchards' => $mouchards,
            'nombre' => $nombreNonLu
        ]);
    }

    /**
     * @Route("/backend/tableau-de-bord", name="backend")
     */
    public function backendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cpteurPartenaire = $em->getRepository("AppBundle:Partenaire")->cpteurPartenaire();
        $cpteurAnnonceur = $em->getRepository("AppBundle:Utilisateur")->cptUser();
        $cpteurBien = $em->getRepository("AppBundle:Bien")->calcul()->getQuery()->getSingleScalarResult();
        $cpteurAnnonce = $em->getRepository("AppBundle:AnnonceBien")->cpteurAnnonce();
        // Liste des biens et annonces les plus vus
        $vuBiens = $em->getRepository("AppBundle:Bien")->findBienPlusVu();
        $vuAnnonces = $em->getRepository("AppBundle:AnnonceBien")->findAnnoncePlusVues();
        //Liste des nouveaux inscrits
        $utilisateurs = $em->getRepository("AppBundle:Utilisateur")->findLastUser(6);
        // Liste des logs
        $logs = $em->getRepository("AppBundle:Mouchard")->findLast(6);
        return $this->render('default/dashboard.html.twig',[
            'partenaire' => $cpteurPartenaire,
            'annonceur' => $cpteurAnnonceur,
            'bien' => $cpteurBien,
            'annonce' => $cpteurAnnonce,
            'biens' => $vuBiens,
            'annonces' => $vuAnnonces,
            'utilisateurs' => $utilisateurs,
            'logs' => $logs,
        ]);
    }
}
