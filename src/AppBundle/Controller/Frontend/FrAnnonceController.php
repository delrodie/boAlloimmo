<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Faq;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Faq controller.
 *
 * @Route("annonce")
 */
class FrAnnonceController extends Controller
{
    /**
     * Page des FAQ
     *
     * @Route("/", name="frontend_internaute_annonce_liste")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $faqs = $em->getRepository('AppBundle:Faq')->findBy(array('statut'=>1), array('question'=>'ASC'));

        return $this->render('frontend/faq.html.twig', array(
            'faqs' => $faqs,
        ));
    }

    /**
     * Affichage de l'annonce 
     * 
     * @Route("/{typebien}/{slug}", name="frontend_internaute_annonce_show")
     * @Method({"GET", "POST"}) 
     */
    public function annonceAction($typebien, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $bien = $em->getRepository('AppBundle:AnnonceBien')->findOneBy(array('slug' => $slug)); //dump($bien);die();
        $similaires = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $bien->getTypebien()->getId()), array('slug' => 'DESC'), 4, 0);
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
            $appartement = $em->getRepository('AppBundle:AnnonceAppartement')->findOneBy(array('annoncebien' => $bien->getId()));

            if (!$appartement) return $this->redirectToRoute('homepage');

            return $this->render("internaute/appartement.html.twig", [
                'appartement' => $appartement,
                'similaires'    => $similaires,
                'photos' => $photos,
            ]);

        }elseif ($bien->getTypebienslug() === 'villa'){
            $villa = $em->getRepository('AppBundle:AnnonceVilla')->findOneBy(array('annoncebien' => $bien->getId())); 

            if(!$villa){
                return $this->redirectToRoute('homepage');
            }

            return $this->render("internaute/villa.html.twig", [
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

        return $this->render('internaute/annonce_show.html.twig',[
            'bien' => $bien,
        ]);
    }
}
