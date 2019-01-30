<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Utils\Gestionannonce;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FrInternauteController
 * @Route("/internautes")
 */
class FrInternauteController extends Controller
{
    /**
     * @Route("/delete", name="frontend_internaute_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, Gestionannonce $gestionannonce)
    {
        $bien = $request->get('id');
        $user = $request->get('user');
        $id = $request->get('userId');
        $crsf = $request->get('crsf_annonce'); //dump($bien);die();

        if ($crsf === 'AlloImmoHabitat!2019'){
            $suppressionAnnonce = $gestionannonce->suppression($bien);

            if ($suppressionAnnonce){
                return $this->redirectToRoute('frontend_annonceur_index',['user'=> $user, 'id'=> $id]);
            }else{
                dump('Echec de suppression');die();
            }
        }
    }

    /**
     * Suppression depuis le backoffice
     * @Route("/delete/backend", name="backend_annonce_delete")
     * @Method({"GET", "POST"})
     */
    public function admindeleteAction(Request $request, Gestionannonce $gestionannonce)
    {
        $annonce = $request->get('bien');
        $crsf = $request->get('crsf_annonce'); //dump($bien);die();

        if ($crsf === 'AlloImmoHabitat!2019'){
            $suppressionAnnonce = $gestionannonce->suppression($annonce);

            if ($suppressionAnnonce){
                return $this->redirectToRoute('backend_annoncebien_index');
            }else{
                dump('Echec de suppression');die();
            }
        }

    }
}
