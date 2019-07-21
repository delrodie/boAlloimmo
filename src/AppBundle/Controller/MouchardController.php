<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Mouchard;
use AppBundle\Utils\GestionMouchard;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mouchard controller.
 *
 * @Route("backend/mouchard")
 */
class MouchardController extends Controller
{
    /**
     * Lists all mouchard entities.
     *
     * @Route("/", name="backend_mouchard_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $listeMouchards= $em->getRepository('AppBundle:Mouchard')->findList();
        $mouchards = $this->get('knp_paginator')->paginate(
            $listeMouchards,
            $request->query->get('page', 1), 6
        );

        return $this->render('mouchard/index.html.twig', array(
            'mouchards' => $mouchards,
        ));
    }

    /**
     * Finds and displays a mouchard entity.
     *
     * @Route("/{id}", name="backend_mouchard_show")
     * @Method("GET")
     */
    public function showAction(Mouchard $mouchard, GestionMouchard $gestionMouchard)
    {
        $gestion = $gestionMouchard->changeFlag($mouchard->getId());
        if ($gestion){
            return $this->render('mouchard/show.html.twig', array(
                'mouchard' => $mouchard,
            ));
        }else{
            return $this->redirectToRoute('backend_mouchard_index');
        }

    }
}
