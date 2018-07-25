<?php

namespace AppBundle\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 *
 * @Route("contact")
 */
class FrContactController extends Controller
{
    /**
     *
     * @Route("/", name="frontend_contact")
     * @Method("GET")
     */
    public function indexAction()
    {
        return $this->render('frontend/contact.html.twig');
    }

    /**
     * @Route("/mail", name="frontend_contact_mail")
     * @Method({"GET", "POST"})
     */
    public function mailAction(Request $request, \Swift_Mailer $mailer)
    {
        $nom = $request->get('Nom');
        $email = $request->get('Email');
        $telephone = $request->get('Phone');
        $observation = $request->get('Message');

        $message = (new \Swift_Message('UNE REQUETE INTERNAUTE DEPUIS ALLOIMMO.CI'))
                    ->setFrom(['noreply@alloimmo.ci' => 'ALLOIMMO.CI'])
                    //->setTo($partenaire)
                    ->setTo(['logitekci@gmail.com', 'info@alloimmo.ci'])
                    //->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
                    //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
                    ->setBcc('delrodieamoikon@gmail.com')
                    ->setReplyTo($email)
                    ->setBody(
                        $this->renderView(
                          'email/mail_contact.html.twig',[
                            'nom' => $nom,
                            'email' => $email,
                            'telephone' => $telephone,
                            'observation' => $observation,
                          ]
                        ), 'text/html'
                      )
        ;

        if ($mailer->send($message)) {
            $this->addFlash('notice', 'Votre message a bien été envoyé !?');
        } else {
            $this->addFlash('erreur', 'ne sommes desolé votre message n\'a pas pu être envoyé');
        }

        /*return $this->render('email/mail_contact.html.twig',[
            'nom' => $nom,
            'email' => $email,
            'telephone' => $telephone,
            'observation' => $observation,
          ]);*/
        

        return $this->redirectToRoute('frontend_contact');
    }

    /**
     * @Route("/partenaire/contact", name="frontend_contact_partenaire")
     * @Method({"GET", "POST"})
     */
    public function partenaireAction(Request $request, \Swift_Mailer $mailer)
    {
        $nom = $request->get('Nom');
        $prenom = $request->get('Prenoms');
        $email = $request->get('Email');
        $telephone = $request->get('Telephone');
        $observation = $request->get('Message');

        $partenaireNom = $request->get('partenaireNom');
        $partenaireEmail = $request->get('partenaireEmail');
        $partenaireSlug = $request->get('partenaireSlug');

        if ($partenaireEmail) {
            $destinataire = $partenaireEmail;
        } else {
            $destinataire = 'logitekci@gmail.com';
            $destinataire .= 'info@alloimmo.ci';
        }
        

        $message = (new \Swift_Message('UN INTERNAUTE CHERCHE A VOUS CONTACTER DEPUIS ALLOIMMO.CI'))
                    ->setFrom(['noreply@alloimmo.ci' => 'ALLOIMMO.CI'])
                    //->setTo($partenaire)
                    ->setTo($destinataire)
                    //->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
                    //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
                    ->setBcc('delrodieamoikon@gmail.com')
                    ->setReplyTo($email)
                    ->setBody(
                        $this->renderView(
                          'email/mail_contact.html.twig',[
                            'nom' => $nom,
                            'email' => $email,
                            'telephone' => $telephone,
                            'observation' => $observation,
                          ]
                        ), 'text/html'
                      )
        ;

        $message2 = (new \Swift_Message('UN INTERNAUTE CHERCHE A CONTACTER UN PARTENAIRE ALLOIMMO.CI'))
                    ->setFrom(['noreply@alloimmo.ci' => 'ALLOIMMO.CI'])
                    //->setTo($partenaire)
                    ->setTo(['logitekci@gmail.com', 'info@alloimmo.ci'])
                    //->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
                    //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
                    ->setBcc('delrodieamoikon@gmail.com')
                    ->setReplyTo($email)
                    ->setBody(
                        $this->renderView(
                          'email/mail_contact.html.twig',[
                            'nom' => $nom,
                            'email' => $email,
                            'telephone' => $telephone,
                            'observation' => $observation,
                          ]
                        ), 'text/html'
                      )
        ;

        if ($mailer->send($message)) {
            $mailer->send($message2);
            $this->addFlash('notice', 'Votre message a bien été envoyé !?');
        } else {
            $this->addFlash('erreur', 'ne sommes desolé votre message n\'a pas pu être envoyé');
        }

        /*return $this->render('email/mail_contact.html.twig',[
            'nom' => $nom,
            'email' => $email,
            'telephone' => $telephone,
            'observation' => $observation,
          ]);*/
        

        return $this->redirectToRoute('frontend_annuaire');
    }

}
