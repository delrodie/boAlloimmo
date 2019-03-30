<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bien;
use AppBundle\Utils\Utilities;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bien controller.
 *
 * @Route("backend/bien")
 */
class BienController extends Controller
{
    /**
     * Lists all bien entities.
     *
     * @Route("/", name="backend_bien_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $filtre = $request->get('filtre');

        if ($filtre){
            $listeBiens = $em->getRepository('AppBundle:Bien')->findByTypebien($filtre);
            $biens = $this->get('knp_paginator')->paginate(
                $listeBiens,
                $request->query->get('page', 1), 6
            );
        }else{
            $listeBiens = $em->getRepository('AppBundle:Bien')->findAllDesc();
            $biens = $this->get('knp_paginator')->paginate(
                $listeBiens,
                $request->query->get('page', 1), 6
            );
        }

        $typebiens = $em->getRepository('AppBundle:Typebien')->findList();

        return $this->render('bien/index.html.twig', array(
            'biens' => $biens,
            'typebiens' => $typebiens,
        ));
    }

    /**
     * Creates a new bien entity.
     *
     * @Route("/new", name="backend_bien_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, Utilities $utilities)
    {
        $bien = new Bien();
        $form = $this->createForm('AppBundle\Form\BienType', $bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $bien->setPrix($utilities->formatage_prix($bien->getPrix()));
            $resume = $utilities->resume($bien->getDescription(), 103, '...', true);
            $typebienslug = $utilities->resume($bien->getTypebien()->getSlug(), 5, '', true);
            $bien->setResume($resume);
            $bien->setTypebienslug($typebienslug);
            $em->persist($bien);
            $em->flush();

            if ($typebienslug === 'immeu'){
                return $this->redirectToRoute('backend_immeuble_new', array('bien' => $bien->getId()));
            }elseif ($typebienslug === 'appar'){
                return $this->redirectToRoute('backend_appartement_new', array('bien' => $bien->getId()));
            }elseif ($typebienslug === 'villa'){
                return $this->redirectToRoute('backend_villa_new', array('bien' => $bien->getId()));
            }else{
                return $this->redirectToRoute('backend_autrebien_new', array('bien' => $bien->getId()));
            }


        }

        return $this->render('bien/new.html.twig', array(
            'bien' => $bien,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a bien entity.
     *
     * @Route("/{slug}", name="backend_bien_show")
     * @Method("GET")
     */
    public function showAction(Bien $bien)
    {
        $em = $this->getDoctrine()->getManager();

        if ($bien->getTypebienslug() === 'immeu'){
            $immeuble = $em->getRepository('AppBundle:Immeuble')->findOneBy(array('bien' => $bien->getId()));
            if ($immeuble){
                return $this->redirectToRoute('backend_immeuble_show', array('id' => $immeuble->getId(), 'bien' =>$bien->getSlug()));
            }else{
                return $this->redirectToRoute('backend_immeuble_new', array('bien' => $bien->getId()));
            }
        }elseif ($bien->getTypebienslug() === 'appar'){
            $appartement = $em->getRepository('AppBundle:Appartement')->findOneBy(array('bien' => $bien->getId()));
            if ($appartement){
                return $this->redirectToRoute('backend_appartement_show', array('id' => $appartement->getId(), 'bien' =>$bien->getSlug()));
            }else{
                return $this->redirectToRoute('backend_appartement_new', array('bien' => $bien->getId()));
            }
        }elseif ($bien->getTypebienslug() === 'villa'){
            $villa = $em->getRepository('AppBundle:Villa')->findOneBy(array('bien' => $bien->getId()));
            if ($villa){
                return $this->redirectToRoute('backend_villa_show', array('id' => $villa->getId(), 'bien' =>$bien->getSlug()));
            }else{
                return $this->redirectToRoute('backend_villa_new', array('bien' => $bien->getId()));
            }
        }else{
            $autrebien = $em->getRepository('AppBundle:Autrebien')->findOneBy(array('bien' => $bien->getId()));
            if ($autrebien){
                return $this->redirectToRoute('backend_autrebien_show', array('id' => $autrebien->getId(), 'bien' =>$bien->getSlug()));
            }else{
                return $this->redirectToRoute('backend_autrebien_new', array('bien' => $bien->getId()));
            }
        }

        $autrebien = $em->getRepository('AppBundle:Autrebien')->findOneBy(array('bien' => $bien->getId()));
        if ($autrebien){
            return $this->redirectToRoute('backend_autrebien_show', array('id' => $autrebien->getId(), 'bien' =>$bien->getSlug()));
        }

        $deleteForm = $this->createDeleteForm($bien);

        return $this->render('bien/show.html.twig', array(
            'bien' => $bien,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bien entity.
     *
     * @Route("/{slug}/edit", name="backend_bien_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Bien $bien, Utilities $utilities)
    {
        $deleteForm = $this->createDeleteForm($bien);
        $editForm = $this->createForm('AppBundle\Form\BienType', $bien);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $bien->setPrix($utilities->formatage_prix($bien->getPrix()));
            $resume = $utilities->resume($bien->getDescription(), 103, '...', true);
            $typebienslug = $utilities->resume($bien->getTypebien()->getSlug(), 5, '', true);
            $bien->setResume($resume); //dump($resume);die();
            $bien->setTypebienslug($typebienslug);
            $this->getDoctrine()->getManager()->flush();

            $em = $this->getDoctrine()->getManager();

            if ($typebienslug === 'immeu'){
                $immeuble = $em->getRepository('AppBundle:Immeuble')->findOneBy(array('bien' => $bien->getId()));
                if ($immeuble){
                    return $this->redirectToRoute('backend_immeuble_edit', array('id' => $immeuble->getId(), 'bien' =>$bien->getSlug()));
                }else{
                    return $this->redirectToRoute('backend_immeuble_new', array('bien' => $bien->getId()));
                }
            }elseif ($typebienslug === 'appar'){
                $appartement = $em->getRepository('AppBundle:Appartement')->findOneBy(array('bien' => $bien->getId()));
                if ($appartement){
                    return $this->redirectToRoute('backend_appartement_edit', array('id' => $appartement->getId(), 'bien' =>$bien->getSlug()));
                }else{
                    return $this->redirectToRoute('backend_appartement_new', array('bien' => $bien->getId()));
                }
            }elseif ($typebienslug === 'villa'){
                $villa = $em->getRepository('AppBundle:Villa')->findOneBy(array('bien' => $bien->getId()));
                if ($villa){
                    return $this->redirectToRoute('backend_villa_edit', array('id' => $villa->getId(), 'bien' =>$bien->getSlug()));
                }else{
                    return $this->redirectToRoute('backend_villa_new', array('bien' => $bien->getId()));
                }
            }else{
                $autrebien = $em->getRepository('AppBundle:Autrebien')->findOneBy(array('bien' => $bien->getId()));
                if ($autrebien){
                    return $this->redirectToRoute('backend_autrebien_edit', array('id' => $autrebien->getId(), 'bien' =>$bien->getSlug()));
                }else{
                    return $this->redirectToRoute('backend_autrebien_new', array('bien' => $bien->getId()));
                }
            }


            return $this->redirectToRoute('backend_bien_edit', array('slug' => $bien->getSlug()));
        }

        return $this->render('bien/edit.html.twig', array(
            'bien' => $bien,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bien entity.
     *
     * @Route("/{id}", name="backend_bien_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Bien $bien)
    {
        $form = $this->createDeleteForm($bien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bien);
            $em->flush();
        }

        return $this->redirectToRoute('backend_bien_index');
    }

    /**
     * Creates a form to delete a bien entity.
     *
     * @param Bien $bien The bien entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Bien $bien)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_bien_delete', array('id' => $bien->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
