<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Utilisateur;
use AppBundle\Utils\GestionMouchard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("profile")
 */
class FrProfileController extends Controller
{
    /**
     * http://localhost:8000/register/confirmed
     *
     * @Route("/", name="frontend_profile_confirmation")
     * @Method({"GET", "POST"})
     */
    public function confirmationAction(Request $request, AuthorizationCheckerInterface $authChecker, \Swift_Mailer $mailer, GestionMouchard $mouchard)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        // Enregistrement du mouchard
        $username = $user->getUsername();
        $titre = "Creation de compte utilisateur";
        $description = "L'internaute ".$username." s'est enregistré comme annonceur. ";
        $lien = "www.alloimmo.ci/admin/user/".$user->getId()."/edit";
        $mouchard->createMouchard($username,$titre,$description,$lien);

        // Envoi de mail de confirmation d'enregistrement de compte utilisateur
        $message = (new \Swift_Message('Enregistrement de compte effectif sur alloimmo.ci'))
            ->setFrom(['noreply@alloimmo.ci' => 'ALLOIMMO.CI'])
            //->setTo($partenaire)
            ->setTo($user->getEmail())
            //->setTo(['delrodieamoikon@gmail.com', 'delrodieamoikon@outlook.fr'])
            //->setBcc(['info@alloimmo.ci', 'delrodieamoikon@gmail.com'])
            ->setBcc(['delrodieamoikon@gmail.com', 'info@alloimmo.ci'])
            ->setReplyTo('info@alloimmo.ci')
            ->setBody(
                $this->renderView(
                    'email/mail_confirmation.html.twig',[
                        'user' => $user,
                    ]
                ), 'text/html'
            )
        ;

        if ($mailer->send($message)) {
            //dump($message);die();
            $this->addFlash('notice', 'Les champs avec axterix sont obligatoires');
        } else {
            $this->addFlash('erreur', 'Les champs avec asterix sont obligatoires!');
        }
        /*return $this->render('email/mail_confirmation.html.twig',[
            'user' => $user,
        ]);*/
        //dump($user);die();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $verifExistenceUser = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));

        if ($verifExistenceUser) { //dump( $user->getUsername()); die();
            return $this->redirectToRoute('frontend_profile_show', [
                'id' => $verifExistenceUser->getId(),
                'user' => $verifExistenceUser->getUser()->getUsername(),
            ]);
        }


        $utilisateur = new Utilisateur();
        $form = $this->createForm('AppBundle\Form\Internaute\ProfileType', $utilisateur, array('user' => $user->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('frontend_profile_show', [
                'id' => $utilisateur->getId(),
                'user' => $utilisateur->getUser()->getUsername(),
            ]);
        }//dump($user);die();

        return $this->render('internaute/_confirmation.html.twig', array(
            'utilisateur' => $utilisateur,
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/enregistrement", name="frontend_profile_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, AuthorizationCheckerInterface $authChecker)
    {
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        // Test de la non existence d'un compte pur cet user
        $verifExistenceUser = $em->getRepository('AppBundle:Utilisateur')->findOneBy(array('user'=>$user->getId()));

        if ($verifExistenceUser) { //dump( $user->getUsername()); die();
            return $this->redirectToRoute('frontend_profile_show', [
                'id' => $verifExistenceUser->getId(),
                'user' => $verifExistenceUser->getUser()->getUsername(),
            ]);
        }


        $utilisateur = new Utilisateur();
        $form = $this->createForm('AppBundle\Form\Internaute\ProfileType', $utilisateur, array('user' => $user->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute('frontend_profile_show', [
                'id' => $utilisateur->getId(),
                'user' => $utilisateur->getUser()->getUsername(),
            ]);
        }//dump($user);die();

        return $this->render('internaute/gestion.html.twig', array(
            'utilisateur' => $utilisateur,
            'user' => $user,
            'type' => 'save',
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("s/{user}-{id}", name="frontend_profile_show")
     * @Method("GET")
     */
    public function showAction(Utilisateur $utilisateur, AuthorizationCheckerInterface $authChecker)
    {
        $em = $this->getDoctrine()->getManager();
        //$utilisateur = $em->getRepository("AppBundle:Utilisateur")->findOneBy(['id'=>$id]);
        //dump($utilisateur);die();
        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        if (!$utilisateur) {
            return $this->redirectToRoute('frontend_profile_new');
        }//dump($utilisateur);die();
        if ($utilisateur->getStatut()){
            $message = '<h4>Votre compte est désactivé. Veuillez contacter l\'administrateur</h4>
                            <h5>info@alloimmo.ci</h5>
							<h5>00225 75 83 33 75</h5>';
            return $this->render('internaute/404.html.twig',[
                'messageError'=>$message,
                'utilisateur' => $utilisateur
            ]);
        }

        $profile = $em->getRepository("AppBundle:Profile")->findOneBy(['statut'=>1], ['id'=>'DESC']);
        return $this->render('internaute/show.html.twig', [
            'utilisateur' => $utilisateur,
            'profile' => $profile
        ]);
    }

    /**
     * @Route("s/{user}-{id}/modifier", name="frontend_profile_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Utilisateur $utilisateur, AuthorizationCheckerInterface $authChecker)
    {

        if (true === $authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend');
        }

        $user = $this->getUser();
        $form = $this->createForm('AppBundle\Form\Internaute\ProfileType', $utilisateur, array('user' => $user->getId()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('frontend_profile_show', [
                'id' => $utilisateur->getId(),
                'user' => $utilisateur->getUser()->getUsername(),
            ]);
        }

        return $this->render('internaute/gestion.html.twig', array(
            'utilisateur' => $utilisateur,
            'type' => 'modification',
            'form' => $form->createView(),
        ));
    }
}
