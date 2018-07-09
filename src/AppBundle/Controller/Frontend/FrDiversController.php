<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

class FrDiversController extends Controller
{
    /**
     * Page des FAQ
     *
     * @Route("/{domaine}/liste-des-partenaires", name="frontend_domaines_liste_partenaires")
     * @Method("GET")
     */
    public function indexAction($domaine)
    {
        $em = $this->getDoctrine()->getManager();

        $partenaires = $em->getRepository('AppBundle:Partenaire')->findListePartenaireByDomaine($domaine, 10, 0); //dump($partenaires); die();
        $listeservices = $em->getRepository('AppBundle:Service')->findListeServiceBy($domaine);
        $domaine = $em->getRepository('AppBundle:Domaine')->findOneBy(array('slug' => $domaine));
        $autreDomaines = $em->getRepository('AppBundle:Domaine')->findAutreDomaine($domaine);

        $promotions = $em->getRepository('AppBundle:Bien')
            ->findBienEnPromo(0, 4);
        $domaines = $em->getRepository('AppBundle:Domaine')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $biens = $em->getRepository('AppBundle:Bien')
            ->findDernierBienEnPromo(4, 0);

        return $this->render('frontend/annuaire_liste_prestataires_par_domaine.html.twig', array(
          'domaine' => $domaine,
          'autreDomaines' => $autreDomaines,
          'partenaires'    => $partenaires,
          'listeservices' => $listeservices,
          'domaines' => $domaines,
          'promotions' => $promotions,
          'biens' => $biens,
        ));
    }
}
