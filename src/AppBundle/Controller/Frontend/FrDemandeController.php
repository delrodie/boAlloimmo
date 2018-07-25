<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("demande")
 */
class FrDemandeController extends Controller
{
    /**
     *
     * @Route("/", name="frontend_demande")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typebiens = $em->getRepository('AppBundle:Typebien')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $zones = $em->getRepository('AppBundle:Zone')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $services = $em->getRepository('AppBundle:Service')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $modes = $em->getRepository('AppBundle:Mode')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));

        return $this->render('frontend/demande.html.twig',[
            'typebiens' => $typebiens,
            'zones' => $zones,
            'services' => $services,
            'modes' => $modes,
        ]);
    }

    /**
     * @Route("/mail", name="frontend_demande_mail")
     * @Method({"GET", "POST"})
     */
    public function mailAction(Request $request, \Swift_Mailer $mailer)
    {
        $civilite = $request->get('Civilite'); //dump($civilite);die();
        $nom = $request->get('Nom');
        $email = $request->get('Email');
        $telephone = $request->get('Phone');
        $typebien = $request->get('Typebien');
        $mode = $request->get('Mode');
        $zone = $request->get('Zone');
        $piece = $request->get('Piece');

        $message = (new \Swift_Message('UN INTERNAUTE FAIT UNE DEMANDE DE RECHERCHE SUR ALLOIMMO.CI'))
                    ->setFrom(['noreply@alloimmo.ci' => 'ALLOIMMO.CI'])
                    //->setTo($partenaire)
                    ->setTo(['logitekci@gmail.com', 'info@alloimmo.ci'])
                    //->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
                    //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
                    ->setBcc('delrodieamoikon@gmail.com')
                    ->setReplyTo($email)
                    ->setBody(
                        $this->renderView(
                          'email/mail_demande.html.twig',[
                            'nom' => $nom,
                            'email' => $email,
                            'telephone' => $telephone,
                            'typebien' => $typebien,
                            'mode' => $mode,
                            'zone' => $zone,
                            'piece' => $piece,
                            'civilite' => $civilite,
                          ]
                        ), 'text/html'
                      )
        ;

        if ($mailer->send($message)) {
            $this->addFlash('notice', 'Votre message a bien été envoyé !?');
        } else {
            $this->addFlash('erreur', 'ne sommes desolé votre message n\'a pas pu être envoyé');
        }

        /*return $this->render('email/mail_demande.html.twig',[
            'nom' => $nom,
                            'email' => $email,
                            'telephone' => $telephone,
                            'typebien' => $typebien,
                            'mode' => $mode,
                            'zone' => $zone,
                            'piece' => $piece,
                            'civilite' => $civilite,
          ]);*/
        

        return $this->redirectToRoute('frontend_annonce');
    }

}
