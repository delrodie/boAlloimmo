<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends Controller
{
    /**
     * Affichage du bien selectionné
     *
     * @Route("/page/{typebien}/{slug}", name="frontend_bien")
     */
    public function bienAction(Request $request, $typebien, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('slug' => $slug)); 
        $similaires = $em->getRepository('AppBundle:Bien')->findBy(array('typebien' => $bien->getTypebien()->getId()), array('slug' => 'DESC'), 3, 0);
        $photos = $em->getRepository('AppBundle:Galleriebien')->findBy(array('bien' => $bien->getId()));

        // Verification du type de bien puis renvoie a la page correspondante a ce type de bien
        if ($bien->getTypebienslug() === 'immeu'){
            $immeuble = $em->getRepository('AppBundle:Immeuble')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/immeuble.html.twig", [
                'immeuble' => $immeuble,
                'similaires'    => $similaires,
                'photos' => $photos,
            ]);

        }elseif ($bien->getTypebienslug() === 'appar'){
            $appartement = $em->getRepository('AppBundle:Appartement')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/appartement.html.twig", [
                'appartement' => $appartement,
                'similaires'    => $similaires,
                'photos' => $photos,
            ]);

        }elseif ($bien->getTypebienslug() === 'villa'){
            $villa = $em->getRepository('AppBundle:Villa')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/villa.html.twig", [
                'villa' => $villa,
                'similaires'    => $similaires,
                'photos' => $photos,
            ]);
        }else{
            $autrebien = $em->getRepository('AppBundle:Autrebien')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/autrebien.html.twig", [
                'autrebien' => $autrebien,
                'similaires'    => $similaires,
                'photos' => $photos,
            ]);

        }

        return $this->redirectToRoute("homepage");
    }

    /**
     * Listes des biens pour l'annuaires
     *
     * @Route("/annonces", name="frontend_annonce")
     */
    public function annonceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $listeBiens = $em->getRepository('AppBundle:AnnonceBien')->findListDesc(); //dump($biens);die();
        $biens = $this->get('knp_paginator')->paginate(
            $listeBiens,
            $request->query->get('page', 1), 15
        );

        return $this->render("internaute/annonce.html.twig", [
            'biens' => $biens,
        ]);
    }

    /**
     * Affichage de la page qui sommes-nous
     *
     * @Route("/page/{rubrique}/{slug}/", name="frontend_page")
     */
    public function pageAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $page = $em->getRepository('AppBundle:Article')->findOneBy(array('slug'=> $slug));
        $publicites = $em->getRepository('AppBundle:Publicite')->findPubliciteEncours(0,4);


        return $this->render("frontend/page.html.twig", [
            'page'  => $page,
            'publicites'  => $publicites,
        ]);
    }

    /**
     * Liste des articles de conseils et guides
     *
     * @Route("/{page}/conseils-et-guide/", name="frontend_conseils")
     */
    public function conseilAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $listeArticles = $em->getRepository('AppBundle:Article')
            ->findArticleByRubrique($slug = 'conseil');
        $articles = $this->get('knp_paginator')->paginate(
            $listeArticles,
            $request->query->get('page', 1), 6
        );
        $publicites = $em->getRepository('AppBundle:Publicite')->findPubliciteEncours(0,4);


        return $this->render("frontend/conseil.html.twig", [
            'articles'  => $articles,
            'publicites'  => $publicites,
        ]);
    }

}
