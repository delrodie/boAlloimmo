<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrPartenaireCompteController
 * @Route("annonces/partenaire")
 */
class FrPartenaireCompteController extends Controller
{
    /**
     * @param $comptes
     * @Route("/{partenaire}", name="frontend_partenaire_compte")
     * @Method({"GET", "POST"})
     */
    public function compteAction($partenaire)
    {
        $em = $this->getDoctrine()->getManager();
        $comptes = $em->getRepository('AppBundle:PartenaireCompte')->verif($partenaire);

        return $this->render('frontend/partenaire_compte.html.twig', [
            'comptes' => $comptes
        ]);
    }
}
