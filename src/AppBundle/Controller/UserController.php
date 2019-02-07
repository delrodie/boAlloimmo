<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Utils\Gestionuser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("admin/user")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="admin_user_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('AppBundle:User')->findListAll();

        return $this->render('user/index.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="admin_user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager(); //$request->get()
            $partenaire = $request->get('partenaire'); //dump($partenaire);die();
            $user->setEnabled(true);
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            // Test d'existence du compte partenaire
            if ($partenaire){
                $partenaireCompte = $em->getRepository('AppBundle:PartenaireCompte')->findOneBy(['partenaire'=>$partenaire]);
                if ($partenaireCompte){
                    $message = "Un compte existe déja pour ce partenaire. !!!";
                    return $this->render('backend/404.html.twig',['message'=>$message]);
                }
            }
            $em->persist($user);
            $em->flush();

            if ($partenaire){ //die('ici');
                return $this->redirectToRoute('backend_compte_new',[
                    'partenaire' => $partenaire,
                    'user' => $user->getUsername(),
                ]);
            }

            return $this->redirectToRoute('admin_user_index');
        }

        $em = $this->getDoctrine()->getManager();
        $partenaires = $em->getRepository('AppBundle:Partenaire')->getListeAsc();

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
            'partenaires' => $partenaires
        ));
    }

    /**
     * Finds and displays a user entity.
     *
     * @Route("/{id}", name="admin_user_show")
     * @Method("GET")
     */
    public function showAction(User $user)
    {
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('user/show.html.twig', array(
            'user' => $user,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{id}/edit", name="admin_user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, User $user)
    {
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('AppBundle\Form\UserType', $user, array(
            'action' => $this->generateUrl('admin_user_edit', array('id' => $user->getId())),
            //'method' => 'PUT',
            'passwordRequired' => false,
            //'lockedRequired' => true
        ));
        $editForm->handleRequest($request);

        $em = $this->getDoctrine()->getManager();

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $encoder = $this->container->get('security.password_encoder');
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);
            $this->getDoctrine()->getManager()->flush();
            $partenaire = $request->get('partenaire');

            if ($partenaire) { //die('ici');
                $partenaireCompte = $em->getRepository('AppBundle:PartenaireCompte')->findOneBy(['partenaire'=>$partenaire]);
                return $this->redirectToRoute('backend_compte_edit', [
                    'id' => $partenaireCompte->getId(),
                    'partenaire' => $partenaireCompte->getPartenaire(),
                ]);
            }
            return $this->redirectToRoute('admin_user_index');
        }
        $partenaire = $em->getRepository('AppBundle:PartenaireCompte')->findOneBy(['user'=> $user->getUsername()]);

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'partenaire' => $partenaire,
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="admin_user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user, Gestionuser $gestionuser)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Test d'appartenance a l'utilisateur
            $utilisateur = $em->getRepository('AppBundle:Utilisateur')->findOneBy(['user'=>$user->getId()]);
            //dump($user);die();
            if ($utilisateur){
                return $this->render('error/utilisateur_a_un_profil.html.twig',[
                    'utilisateur' => $utilisateur,
                ]);
            }
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('admin_user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
