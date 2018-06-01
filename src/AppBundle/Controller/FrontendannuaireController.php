<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontendannuaireController extends Controller
{
    /**
     * Liste des services selon le domaine
     *
     * @Route("/annuaire/", name="frontend_annuaire")
     */
    public function annuaireAction()
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

        $biens = $em->getRepository('AppBundle:Bien')
            ->findBy(array('promotion' => 1));

        $domaines = $em->getRepository('AppBundle:Domaine')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));

        return $this->render("frontend/annuaire.html.twig", [
            'domaines' => $domaines,
            //'pagination'    => $pagination,
            'typebiens' => $typebiens,
            'zones' => $zones,
            'services' => $services,
            'modes' => $modes,
            'biens' => $biens,
        ]);

    }

    /**
     * Liste des services selon le domaine
     *
     * @Route("/annuaire/{domaine}/domaine", name="fannuaire_domaine")
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
     * @Route("/annuaire/domaine/compteur/{domaine}", name="fannuaire_compteur_service")
     */
    public function compteurAction($domaine)
    {
        $em = $this->getDoctrine()->getManager();
        $nombre = $em->getRepository('AppBundle:Service')
            ->findBy(array('domaine' => $domaine), array('libelle' => 'ASC'), 5, 5)
        ;//dump($nombre);die();

        return $this->render("frontend/annuaire_autreservice.html.twig",[
            'nombre' => $nombre,
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

}