<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class FrontendPubliciteController
 * @Route("publicite")
 */
class FrontendPubliciteController extends Controller
{
    /**
     * @Route("/{slug}", name="frontend_publicite")
     */
    public function indexAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $publicite = $em->getRepository("AppBundle:Publicite")->findOneBy(["slug"=>$slug]);
        $autrePublicites = $em->getRepository("AppBundle:Publicite")->findPubliciteEncours(1,10);
        //dump($publicite);die();
        return $this->render('frontend/publicite.html.twig', [
            'publicite' => $publicite,
            'autrePublicites' => $autrePublicites
        ]);
    }
}
