<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Faq;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Faq controller.
 *
 * @Route("foire-aux-questions")
 */
class FrFaqController extends Controller
{
    /**
     * Page des FAQ
     *
     * @Route("/", name="frontend_faq")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $faqs = $em->getRepository('AppBundle:Faq')->findBy(array('statut'=>1), array('question'=>'ASC'));

        return $this->render('frontend/faq.html.twig', array(
            'faqs' => $faqs,
        ));
    }
}
