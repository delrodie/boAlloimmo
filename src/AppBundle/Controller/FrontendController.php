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
        $similaires = $em->getRepository('AppBundle:Bien')->findBy(array('typebien' => $typebien), array('id' => 'DESC'), 0, 4);

        // Verification du type de bien puis renvoie a la page correspondante a ce type de bien
        if ($bien->getTypebienslug() === 'immeu'){
            $immeuble = $em->getRepository('AppBundle:Immeuble')->findOneBy(array('bien' => $bien->getId()));

        }elseif ($bien->getTypebienslug() === 'appar'){
            $appartement = $em->getRepository('AppBundle:Appartement')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/appartement.html.twig", [
                'appartement' => $appartement,
                'similaires'    => $similaires,
            ]);

        }elseif ($bien->getTypebienslug() === 'villa'){
            $villa = $em->getRepository('AppBundle:Villa')->findOneBy(array('bien' => $bien->getId()));

            return $this->render("frontend/villa.html.twig", [
                'villa' => $villa,
                'similaires'    => $similaires,
            ]);
        }else{
            $autrebien = $em->getRepository('AppBundle:Autrebien')->findOneBy(array('bien' => $bien->getId()));

        }
        dump('rien'); die();
        return $this->render("frontend/bien.html.twig");
    }
}