<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnnonceAutrebien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class AnnonceAutrebienController
 * @Route("backend/annonceautrebien")
 */
class AnnonceAutrebienController extends Controller
{
    /**
     * @Route("/{id}/{annoncebien}", name="backend_annonceautrebien_show")
     * @Method("GET")
     */
    public function showAction(AnnonceAutrebien $annonceAutrebien)
    {
        return $this->render('annonceautrebien/show.html.twig',[
            'annonceAutrebien' => $annonceAutrebien,
        ]);
    }
}
