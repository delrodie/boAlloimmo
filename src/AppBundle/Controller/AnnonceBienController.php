<?php

namespace AppBundle\Controller;

use AppBundle\Entity\AnnonceBien;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Annoncebien controller.
 *
 * @Route("backend/annoncebien")
 */
class AnnonceBienController extends Controller
{
    /**
     * Lists all annonceBien entities.
     *
     * @Route("/", name="backend_annoncebien_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $annonceBiens = $em->getRepository('AppBundle:AnnonceBien')->findListDesc();

        return $this->render('annoncebien/index.html.twig', array(
            'annonceBiens' => $annonceBiens,
        ));
    }

    /**
     * Creates a new annonceBien entity.
     *
     * @Route("/new", name="backend_annoncebien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $annonceBien = new Annoncebien();
        $form = $this->createForm('AppBundle\Form\AnnonceBienType', $annonceBien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($annonceBien);
            $em->flush();

            return $this->redirectToRoute('backend_annoncebien_show', array('id' => $annonceBien->getId()));
        }

        return $this->render('annoncebien/new.html.twig', array(
            'annonceBien' => $annonceBien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a annonceBien entity.
     *
     * @Route("/{slug}", name="backend_annoncebien_show")
     * @Method("GET")
     */
    public function showAction(AnnonceBien $annonceBien)
    {
        $em = $this->getDoctrine()->getManager(); //dump($annonceBien);die();

        if ($annonceBien->getTypebienslug() === 'immeu'){
            $immeuble = $em->getRepository('AppBundle:AnnonceImmeuble')->findOneBy(array('annoncebien' => $annonceBien->getId()));
            if ($immeuble){
                return $this->redirectToRoute('backend_annonceimmeuble_show', array('id' => $immeuble->getId(), 'slug' =>$annonceBien->getSlug()));
            }else{
                return $this->redirectToRoute('backend_annonceimmeuble_new', array('annoncebien' => $annonceBien->getId()));
            }
        }elseif ($annonceBien->getTypebienslug() === 'appar'){
            $appartement = $em->getRepository('AppBundle:AnnonceAppartement')->findOneBy(array('annoncebien' => $annonceBien->getId()));
            if ($appartement){
                return $this->redirectToRoute('backend_appartement_show', array('id' => $appartement->getId(), 'annoncebien' =>$annonceBien->getSlug()));
            }else{
                return $this->redirectToRoute('backend_appartement_new', array('annoncebien' => $annonceBien->getId()));
            }
        }elseif ($annonceBien->getTypebienslug() === 'villa'){
            $villa = $em->getRepository('AppBundle:AnnonceVilla')->findOneBy(array('annoncebien' => $annonceBien->getId()));
            if ($villa){
                return $this->redirectToRoute('backend_annoncevilla_show', array('id' => $villa->getId(), 'annoncebien' =>$annonceBien->getSlug()));
            }else{
                return $this->redirectToRoute('backend_annoncevilla_new', array('annoncebien' => $annonceBien->getId()));
            }
        }else{
            $autrebien = $em->getRepository('AppBundle:AnnonceAutrebien')->findOneBy(array('annoncebien' => $annonceBien->getId()));
            if ($autrebien){
                return $this->redirectToRoute('backend_autrebien_show', array('id' => $autrebien->getId(), 'annoncebien' =>$annonceBien->getSlug()));
            }else{
                return $this->redirectToRoute('backend_autrebien_new', array('annoncebien' => $annonceBien->getId()));
            }
        }

        $autrebien = $em->getRepository('AppBundle:AnnonceAutrebien')->findOneBy(array('annoncebien' => $annonceBien->getId()));
        if ($autrebien){
            return $this->redirectToRoute('backend_autrebien_show', array('id' => $autrebien->getId(), 'annoncebien' =>$annonceBien->getSlug()));
        }

        $deleteForm = $this->createDeleteForm($annonceBien);

        return $this->render('bien/show.html.twig', array(
            'annoncebien' => $annonceBien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing annonceBien entity.
     *
     * @Route("/{slug}/edit", name="backend_annoncebien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, AnnonceBien $annonceBien, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($annonceBien);
        $editForm = $this->createForm('AppBundle\Form\AnnonceBienType', $annonceBien);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $annonceBien->setPrix($utilities->formatage_prix($annonceBien->getPrix()));
            $resume = $utilities->resume($annonceBien->getDescription(), 103, '...', true);
            $typebienslug = $utilities->resume($annonceBien->getTypebien()->getSlug(), 5, '', true);
            $annonceBien->setResume($resume); //dump($resume);die();
            $annonceBien->setTypebienslug($typebienslug);
            $this->getDoctrine()->getManager()->flush();

            $em = $this->getDoctrine()->getManager();


            if ($typebienslug === 'immeu'){
                $immeuble = $em->getRepository('AppBundle:AnnonceImmeuble')->findOneBy(array('annoncebien' => $annonceBien->getId()));
                if ($immeuble){
                    return $this->redirectToRoute('backend_annonceimmeuble_edit', array('id' => $immeuble->getId(), 'annoncebien' =>$annonceBien->getSlug()));
                }else{
                    return $this->redirectToRoute('backend_annonceimmeuble_new', array('annoncebien' => $annonceBien->getId()));
                }
            }elseif ($typebienslug === 'appar'){
                $appartement = $em->getRepository('AppBundle:AnnonceAppartement')->findOneBy(array('annoncebien' => $annonceBien->getId()));
                if ($appartement){
                    return $this->redirectToRoute('backend_annonceappartement_edit', array('id' => $appartement->getId(), 'annoncebien' =>$annonceBien->getSlug()));
                }else{
                    return $this->redirectToRoute('backend_annonceappartement_new', array('annoncebien' => $annonceBien->getId()));
                }
            }elseif ($typebienslug === 'villa'){
                $villa = $em->getRepository('AppBundle:AnnonceVilla')->findOneBy(array('annoncebien' => $annonceBien->getId()));
                if ($villa){
                    return $this->redirectToRoute('backend_annoncevilla_edit', array('id' => $villa->getId(), 'annoncebien' =>$annonceBien->getSlug()));
                }else{
                    return $this->redirectToRoute('backend_annoncevilla_new', array('annoncebien' => $annonceBien->getId()));
                }
            }else{
                $autrebien = $em->getRepository('AppBundle:AnnonceAutrebien')->findOneBy(array('annoncebien' => $annonceBien->getId()));
                if ($autrebien){
                    return $this->redirectToRoute('backend_annonceautrebien_edit', array('id' => $autrebien->getId(), 'annoncebien' =>$annonceBien->getSlug()));
                }else{
                    return $this->redirectToRoute('backend_annonceautrebien_new', array('annoncebien' => $annonceBien->getId()));
                }
            }


            return $this->redirectToRoute('backend_annoncebien_edit', array('slug' => $annonceBien->getSlug()));
        }

        return $this->render('annoncebien/edit.html.twig', array(
            'annonceBien' => $annonceBien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a annonceBien entity.
     *
     * @Route("/{id}", name="backend_annoncebien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, AnnonceBien $annonceBien)
    {
        $form = $this->createDeleteForm($annonceBien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($annonceBien);
            $em->flush();
        }

        return $this->redirectToRoute('backend_annoncebien_index');
    }

    /**
     * Creates a form to delete a annonceBien entity.
     *
     * @param AnnonceBien $annonceBien The annonceBien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(AnnonceBien $annonceBien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_annoncebien_delete', array('id' => $annonceBien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
