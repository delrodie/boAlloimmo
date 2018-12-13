<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PartenaireCompte;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PartenaireCompteController
 * @Route("backend/compte")
 */
class PartenaireCompteController extends Controller
{
    /**
     * @Route("/", name="backend_compte_index")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $comptes = $em->getRepository('AppBundle:PartenaireCompte')->findAll();
        return $this->render('backend/compte_list.html.twig', [
            'comptes' => $comptes,
        ]);
    }

    /**
     * @Route("/{id}-{partenaire}", name="backend_compte_edit")
     * @Method({"GET","POST"})
     */
    public function editAction(Request $request, PartenaireCompte $partenaireCompte, $partenaire)
    {
        //$compte = new PartenaireCompte();
        $em = $this->getDoctrine()->getManager();
        if ($partenaireCompte && $partenaire){
            $em->flush();

            $partenaires = $em->getRepository('AppBundle:Partenaire')->findOneBy(['nom'=>$partenaireCompte->getPartenaire()]);
            return $this->render('backend/compte.html.twig',[
                'partenaire' => $partenaires,
                'user' => $partenaireCompte->getUser(),
            ]);
        }

        $user = $em->getRepository('AppBundle:User')->findOneBy(['username'=>$partenaireCompte->getUser()]);

        return $this->redirectToRoute('admin_user_edit', ['id'=>$user->getId()]);
    }

    /**
     * @Route("/{partenaire}/{user}", name="backend_compte_new")
     * @Method({"GET","POST"})
     */
    public function newAction(Request $request, $partenaire, $user)
    {
        $compte = new PartenaireCompte();
        $em = $this->getDoctrine()->getManager();
        if ($partenaire && $user){
            $compte->setPartenaire($partenaire);
            $compte->setUser($user); dump($compte);//die();
            $em->persist($compte);
            $em->flush();

            $partenaires = $em->getRepository('AppBundle:Partenaire')->findOneBy(['nom'=>$partenaire]);
            return $this->render('backend/compte.html.twig',[
                'partenaire' => $partenaires,
                'user' => $user,
            ]);
        }

        return $this->redirectToRoute('admin_user_index');
    }
}
