<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Utilisateur;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class InternauteBienController
 * @Route("backend/internautebien")
 */
class InternauteBienController extends Controller
{
    /**
     * @Route("/{slug}", name="backend_internaute_bien")
     */
    public function indexAction(Utilisateur $utilisateur)
    {
        $em = $this->getDoctrine()->getManager();
        $biens = $em->getRepository('AppBundle:AnnonceBien')
                    ->findBy(
                        ['utilisateur' => $utilisateur->getId()],
                        ['id'=> 'DESC']
                    ); //dump($biens);die();
        return $this->render('backend/internaute_bien.html.twig',[
            'annonceBiens' => $biens,
            'utilisateur' => $utilisateur
        ]);
    }
}
