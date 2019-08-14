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
    public function indexAction(Request $request, Utilisateur $utilisateur)
    {
        $em = $this->getDoctrine()->getManager();
        $filtre = $request->get('filtre');
        $recherche = $request->get('recherche');
        if ($filtre){
            $listeBiens = $em->getRepository('AppBundle:AnnonceBien')->findByTypeBien($filtre, $utilisateur->getId());
            $biens = $this->get('knp_paginator')->paginate(
                $listeBiens,
                $request->query->get('page', 1), 6
            );
        } elseif ($recherche){
            $listeBiens = $em->getRepository('AppBundle:AnnonceBien')->findBySearch($recherche, $utilisateur->getId());
            $biens = $this->get('knp_paginator')->paginate(
                $listeBiens,
                $request->query->get('page', 1), 6
            );
        }
        else{
            $listeBiens = $em->getRepository('AppBundle:AnnonceBien')
                ->findBy(
                    ['utilisateur' => $utilisateur->getId()],
                    ['id'=> 'DESC']
                );
            $biens = $this->get('knp_paginator')->paginate(
                $listeBiens,
                $request->query->get('page', 1), 6
            );
        }
        $typebiens = $em->getRepository('AppBundle:Typebien')->findList();


        return $this->render('backend/internaute_bien.html.twig',[
            'annonceBiens' => $biens,
            'utilisateur' => $utilisateur,
            'typebiens' => $typebiens,
        ]);
    }
}
