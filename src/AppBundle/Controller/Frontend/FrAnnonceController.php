<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Faq;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Faq controller.
 *
 * @Route("annonce")
 */
class FrAnnonceController extends Controller
{
    /**
     * Page des FAQ
     *
     * @Route("/", name="frontend_internaute_annonce_liste")
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

    /**
     * Affichage de l'annonce 
     * 
     * @Route("/{typebien}/{slug}", name="frontend_internaute_annonce_show")
     * @Method({"GET", "POST"}) 
     */
    public function annonceAction($typebien, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $bien = $em->getRepository('AppBundle:AnnonceBien')->findOneBy(array('slug' => $slug)); //dump($bien);die();
        $similaires = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $bien->getTypebien()->getId()), array('slug' => 'DESC'), 4, 0);
        $photos = $em->getRepository('AppBundle:Galleriebien')->findBy(array('bien' => $bien->getId()));
        $compteurSimilaire = $em->getRepository('AppBundle:AnnonceBien')->cpteur($bien->getTypebien()->getId());

        // Verification du type de bien puis renvoie a la page correspondante a ce type de bien
        if ($bien->getTypebienslug() === 'immeu'){
            $immeuble = $em->getRepository('AppBundle:AnnonceImmeuble')->findOneBy(array('annoncebien' => $bien->getId()));

            if (!$immeuble){
                $message = "Le bien recherché n'a pas été trouvé. Soit il a été rétiré par l'annonceur ou il a été vendu. <br>";
                $message .= "Mais si vous pensez que c'est une erreur alors veuillez contacter l'administrateur de la plateforme. <br> ";
                $message .= "Contact : <strong>+225 75 83 33 75</strong><br>";
                $message .= "Email: <strong>info@alloimmo.ci</strong>";
                return $this->render('internaute/404_internaute.html.twig',[
                    'messageError' => $message,
                ]);
            }

            if (!$immeuble->getAnnoncebien()->getStatut()){
                $message = "Le bien recherché n'a pas été trouvé. Soit il a été rétiré par l'annonceur ou il a été vendu. <br>";
                $message .= "Mais si vous pensez que c'est une erreur alors veuillez contacter l'administrateur de la plateforme. <br> ";
                $message .= "Contact : <strong>+225 75 83 33 75</strong><br>";
                $message .= "Email: <strong>info@alloimmo.ci</strong>";
                return $this->render('internaute/404_internaute.html.twig',[
                    'messageError' => $message,
                ]);
            }

            return $this->render("internaute/immeuble.html.twig", [
                'immeuble' => $immeuble,
                'similaires'    => $similaires,
                'photos' => $photos,
                'compteur' => $compteurSimilaire
            ]);

        }elseif ($bien->getTypebienslug() === 'appar'){
            $appartement = $em->getRepository('AppBundle:AnnonceAppartement')->findOneBy(array('annoncebien' => $bien->getId()));

            if (!$appartement) {
                $message = "Le bien recherché n'a pas été trouvé. Soit il a été rétiré par l'annonceur ou il a été vendu. <br>";
                $message .= "Mais si vous pensez que c'est une erreur alors veuillez contacter l'administrateur de la plateforme. <br> ";
                $message .= "Contact : <strong>+225 75 83 33 75</strong><br>";
                $message .= "Email: <strong>info@alloimmo.ci</strong>";
                return $this->render('internaute/404_internaute.html.twig',[
                    'messageError' => $message,
                ]);
            };
            if (!$appartement->getAnnoncebien()->getStatut()){
                $message = "Le bien recherché n'a pas été trouvé. Soit il a été rétiré par l'annonceur ou il a été vendu. <br>";
                $message .= "Mais si vous pensez que c'est une erreur alors veuillez contacter l'administrateur de la plateforme. <br> ";
                $message .= "Contact : <strong>+225 75 83 33 75</strong><br>";
                $message .= "Email: <strong>info@alloimmo.ci</strong>";
                return $this->render('internaute/404_internaute.html.twig',[
                    'messageError' => $message,
                ]);
            }

            return $this->render("internaute/appartement.html.twig", [
                'appartement' => $appartement,
                'similaires'    => $similaires,
                'photos' => $photos,
                'compteur' => $compteurSimilaire
            ]);

        }elseif ($bien->getTypebienslug() === 'villa'){
            $villa = $em->getRepository('AppBundle:AnnonceVilla')->findOneBy(array('annoncebien' => $bien->getId()));

            if(!$villa){
                $message = "Le bien recherché n'a pas été trouvé. Soit il a été rétiré par l'annonceur ou il a été vendu. <br>";
                $message .= "Mais si vous pensez que c'est une erreur alors veuillez contacter l'administrateur de la plateforme. <br> ";
                $message .= "Contact : <strong>+225 75 83 33 75</strong><br>";
                $message .= "Email: <strong>info@alloimmo.ci</strong>";
                return $this->render('internaute/404_internaute.html.twig',[
                    'messageError' => $message,
                ]);
            }
            if (!$villa->getAnnoncebien()->getStatut()){
                $message = "Le bien recherché n'a pas été trouvé. Soit il a été rétiré par l'annonceur ou il a été vendu. <br>";
                $message .= "Mais si vous pensez que c'est une erreur alors veuillez contacter l'administrateur de la plateforme. <br> ";
                $message .= "Contact : <strong>+225 75 83 33 75</strong><br>";
                $message .= "Email: <strong>info@alloimmo.ci</strong>";
                return $this->render('internaute/404_internaute.html.twig',[
                    'messageError' => $message,
                ]);
            }

            return $this->render("internaute/villa.html.twig", [
                'villa' => $villa,
                'similaires'    => $similaires,
                'photos' => $photos,
                'compteur' => $compteurSimilaire
            ]);
        }else{
            $autrebien = $em->getRepository('AppBundle:AnnonceAutrebien')->findOneBy(array('annoncebien' => $bien->getId())); //dump($compteurSimilaire);die();

            if (!$autrebien){
                $message = "Le bien recherché n'a pas été trouvé. Soit il a été rétiré par l'annonceur ou il a été vendu. <br>";
                $message .= "Mais si vous pensez que c'est une erreur alors veuillez contacter l'administrateur de la plateforme. <br> ";
                $message .= "Contact : <strong>+225 75 83 33 75</strong><br>";
                $message .= "Email: <strong>info@alloimmo.ci</strong>";
                return $this->render('internaute/404_internaute.html.twig',[
                    'messageError' => $message,
                ]);
            }

            if (!$autrebien->getAnnoncebien()->getStatut()){
                $message = "Le bien recherché n'a pas été trouvé. Soit il a été rétiré par l'annonceur ou il a été vendu. <br>";
                $message .= "Mais si vous pensez que c'est une erreur alors veuillez contacter l'administrateur de la plateforme. <br> ";
                $message .= "Contact : <strong>+225 75 83 33 75</strong><br>";
                $message .= "Email: <strong>info@alloimmo.ci</strong>";
                return $this->render('internaute/404_internaute.html.twig',[
                    'messageError' => $message,
                ]);
            }

            return $this->render("internaute/autrebien.html.twig", [
                'autrebien' => $autrebien,
                'similaires'    => $similaires,
                'photos' => $photos,
                'compteur' => $compteurSimilaire,
            ]);

        }

        return $this->render('internaute/annonce_show.html.twig',[
            'bien' => $bien,
        ]);
    }
}
