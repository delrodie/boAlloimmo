<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnnonceBien;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class AnnoncePromotionController
 * @Route("/promotion")
 */
class AnnoncePromotionController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     * @Route("/{user}-{id}/{annonce}", name="internaute_annonce_promotion")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request, AuthorizationCheckerInterface $authorizationChecker ,$user, $annonce, $id)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(['user'=>$user->getId()]); //dump($utilisateur); die();

        return $this->render('internaute/annonce_promotion.html.twig',[
            'utilisateur' => $utilisateur
        ]);
    }
}
