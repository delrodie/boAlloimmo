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
     * @Route("/categorie/{slug}/{page}", name="fannuaire_domaine_partenaire")
     */
    public function categorieAction($slug, $page = null)
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

        $partenaires = $em->getRepository('AppBundle:Partenaire')->findListePartenaireByDomaine($slug, 10, 0); //dump($partenaires); die();
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
        ]);
    }

}