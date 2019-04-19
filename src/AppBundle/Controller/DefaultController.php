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
     * @Route("/backend/tableau-de-bord", name="backend")
     */
    public function backendAction(Request $request)
    {
        return $this->render('default/dashboard.html.twig');
    }
}
