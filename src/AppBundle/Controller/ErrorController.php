<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class ErrorController
 * @Route("backend/error")
 */
class ErrorController extends Controller
{
    /**
     * Erreur utilisateur
     * @Route("/{utilisateur}", name="backend_error_utilisateur")
     * @Method("GET")
     */
    public function utilisateurAction($utilisateur)
    {
        //dump($utilisateur);die();
        return $this->render('error/utilisateur_a_un_profil.html.twig');
    }
}
