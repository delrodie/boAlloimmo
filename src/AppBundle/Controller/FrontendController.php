<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends Controller
{
    /**
     * Affichage du bien selectionné
     *
     * @Route("/{typebien}/{slug}", name="frontend_bien")
     */
    public function bienAction(Request $request, $typebien, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $bien = $em->getRepository('AppBundle:Bien')->findOneBy(array('slug' => $slug));
        $similaires = $em->getRepository('AppBundle:Bien')->findBy(array('typebien' => $bien->getTypebien()->getId()), array('slug' => 'DESC'), 4, 0);
        $typebiens = $em->getRepository('AppBundle:Typebien')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $zones = $em->getRepository('AppBundle:Zone')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $services = $em->getRepository('AppBundle:Service')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $modes = $em->getRepository('AppBundle:Mode')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC')); //dump($similaires);die();

        // Verification du type de bien puis renvoie a la page correspondante a ce type de bien
        if ($bien->getTypebienslug() === 'immeu'){
            $immeuble = $em->getRepository('AppBundle:Immeuble')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/immeuble.html.twig", [
                'immeuble' => $immeuble,
                'similaires'    => $similaires,
                'typebiens' => $typebiens,
                'zones' => $zones,
                'services' => $services,
                'modes' => $modes,
            ]);

        }elseif ($bien->getTypebienslug() === 'appar'){
            $appartement = $em->getRepository('AppBundle:Appartement')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/appartement.html.twig", [
                'appartement' => $appartement,
                'similaires'    => $similaires,
                'typebiens' => $typebiens,
                'zones' => $zones,
                'services' => $services,
                'modes' => $modes,
            ]);

        }elseif ($bien->getTypebienslug() === 'villa'){
            $villa = $em->getRepository('AppBundle:Villa')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/villa.html.twig", [
                'villa' => $villa,
                'similaires'    => $similaires,
                'typebiens' => $typebiens,
                'zones' => $zones,
                'services' => $services,
                'modes' => $modes,
            ]);
        }else{
            $autrebien = $em->getRepository('AppBundle:Autrebien')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/autrebien.html.twig", [
                'autrebien' => $autrebien,
                'similaires'    => $similaires,
                'typebiens' => $typebiens,
                'zones' => $zones,
                'services' => $services,
                'modes' => $modes,
            ]);

        }

        return $this->redirectToRoute("homepage");
    }
}