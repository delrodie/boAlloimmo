<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mail controller.
 *
 * @Route("mail")
 */
class FrMailController extends Controller
{
    /**
     * Page des FAQ
     *
     * @Route("/", name="mail_interesse_bien")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request, \Swift_Mailer $mailer)
    {
        $nom = $request->get('Nom');
        $prenoms = $request->get('Prenoms');
        $email = $request->get('Email');
        $telephone = $request->get('Telephone');
        $observation = $request->get('Observation');
        $lien = $request->get('Lien');
        $partenaire = $request->get('Partenaire');

        $typebien = $request->get('Tbien');
        $bien = $request->get('BienSlug'); //dump($bien);die();

        $message = (new \Swift_Message('Envoi de mail effectif depuis le site internet alloimmo.ci'))
                    ->setFrom('noreply@alloimmo.ci')
                    //->setTo($partenaire)
                    ->setTo(['logitekci@gmail.com', 'delrodieamoikon@outlook.fr'])
                    //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
                    ->setBcc('delrodieamoikon@gmail.com')
                    ->setReplyTo($email)
                    ->setBody(
                        $this->renderView(
                          'email/mail_interesse.html.twig',[
                            'nom' => $nom,
                            'prenoms' => $prenoms,
                            'email' => $email,
                            'telephone' => $telephone,
                            'observation' => $observation,
                            'lien'  => $lien,
                          ]
                        ), 'text/html'
                      )
        ;

        if ($mailer->send($message)) {
            $this->addFlash('notice', 'Votre message a bien été envoyé !?');
        } else {
            $this->addFlash('erreur', 'ne sommes desolé votre message n\'a pas pu être envoyé');
        }
        

        return $this->redirectToRoute('frontend_bien',['typebien'=> $typebien, 'slug'=> $bien]);
    }
}
