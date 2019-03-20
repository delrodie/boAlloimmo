<?php

namespace AppBundle\Controller;

use AppBundle\Utils\Utilities;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Base controller.
 *
 * @Route("recherche")
 */
class FRechercheController extends Controller
{
    /**
     * Affichage du formulaire de recherche
     *
     * @Route("/", name="rfrontend_principale")
     */
    public function rechercheAction()
    {
        $em = $this->getDoctrine()->getManager();
        $typebiens = $em->getRepository('AppBundle:Typebien')->findList(); //dump($typebiens);die();
        $zones = $em->getRepository('AppBundle:Zone')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $services = $em->getRepository('AppBundle:Service')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));
        $modes = $em->getRepository('AppBundle:Mode')
            ->findBy(array('statut' => 1), array('libelle' => 'ASC'));

        return $this->render('frontend/recherche_formulaire.html.twig',[
            'typebiens' => $typebiens,
            'zones' => $zones,
            'services' => $services,
            'modes' => $modes,
        ]);

    }

    /**
     * Requête de recherche du service par le formulaire
     *
     * @Route("/services/", name="rfrontend_service")
     * @Method({"GET", "POST"})
     */
    public function serviceAction(Request $request)
    {
        $getService = $request->get('service');

        $em = $this->getDoctrine()->getManager();

        if ($getService){
            $service = $em->getRepository('AppBundle:Service')->findOneBy(array('libelle' => $getService));

            return $this->redirectToRoute('fannuaire_liste_partenaires', [
                'domaine'   => $service->getDomaine()->getSlug(),
                'slug'      => $service->getSlug(),
                'page'      => null,
            ]);
        }else {
            return $this->redirectToRoute('frontend_annuaire');
        }

    }

    /**
     * Recherche de la vente et location par le formulaire
     *
     * @Route("/vente/location/", name="rfrontend_location")
     * @Method("GET")
     */
    public function locationAction(Request $request, Utilities $utilities)
    {

        $session = new Session();

        $typebien = $session->get('typebien');
        $piece = $session->get('piece');
        $localisation = $session->get('localisation');
        $min = $session->get('min');
        $max = $session->get('max');
        $mode = $session->get('mode');

        $em = $this->getDoctrine()->getManager();

        if ($typebien or $piece or $localisation){
            // Si le type de bien est selectionné veifier
            // sinon verifier uniquement la localite
            if ($typebien){
                //$mode = 'Location';
                $typebiens = $em->getRepository('AppBundle:Typebien')->findOneBy(array('libelle'=> $typebien));
                $resume = $utilities->resume($typebiens->getSlug(), 5, '', true);
                $nbPiece = $utilities->resume($piece, 1, '', true);

                //Test d'existence de la zone et formaulation de la requête
                if ($localisation){
                    $whereZone = 'z.libelle = :localite';
                } else{
                    $whereZone = 'z.libelle <> :localite';
                    $localisation = 'a';
                }

                // Formulation de la requete du prix
                if ($min){ $whereMin = 'b.prix >= :min'; }else { $whereMin = 'b.prix >= :min'; $min = 0;}
                if ($max){ $whereMax = 'b.prix <= :max'; } else{ $whereMax = 'b.prix <= :max'; $max = 1000000000; }

                // Verification du type de bien puis renvoie a la page correspondante a ce type de bien
                if ($resume === 'immeu'){
                    // Formulation de la requete du nombre de pièce
                    if (!$nbPiece){
                        $wherePiece = 'i.appartement > :piece'; $nbPiece = 0;
                    } elseif ($nbPiece <= 5){ $wherePiece = 'i.appartement = :piece'; } else{ $wherePiece = 'i.appartement > :piece'; $nbPiece = 5;}

                    $immeubles = $em->getRepository('AppBundle:AnnonceImmeuble')
                        ->findImmeuble($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
                    ;//dump($immeubles);die();
                    $biens = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $typebiens->getId()), null, 9, 0);
                    $pagination = null ;

                    return $this->render('frontend/recherche_annonce_immeuble.html.twig',[
                        'immeubles'        => $immeubles,
                        'pagination'    => $pagination,
                        'typebien'    => $typebien,
                        'biens'    => $biens,
                    ]);

                }elseif ($resume === 'appar'){
                    // Formulation de la requete du nombre de pièce
                    if (!$nbPiece){
                        $wherePiece = 'a.piece > :piece'; $nbPiece = 0;
                    } elseif ($nbPiece <= 5){ $wherePiece = 'a.piece = :piece'; } else{ $wherePiece = 'a.piece > :piece'; $nbPiece = 5;}

                    $appartements = $em->getRepository('AppBundle:AnnonceAppartement')
                        ->findAppartement($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
                    ; //dump($mode);die();
                    $biens = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $typebiens->getId()), null, 9, 0);
                    $pagination = null ;

                    return $this->render('frontend/recherche_annonce_appartement.html.twig',[
                        'appartements'        => $appartements,
                        'pagination'    => $pagination,
                        'typebien'    => $typebien,
                        'biens'    => $biens,
                    ]);

                }elseif ($resume === 'villa'){
                    // Formulation de la requete du nombre de pièce
                    if (!$nbPiece){
                        $wherePiece = 'v.piece > :piece'; $nbPiece = 0;
                    } elseif ($nbPiece <= 5){ $wherePiece = 'v.piece = :piece'; } else{ $wherePiece = 'v.piece > :piece'; $nbPiece = 5;}

                    $villas = $em->getRepository('AppBundle:AnnonceVilla')
                        ->findVilla($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
                    ;
                    $biens = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $typebiens->getId()), null, 9, 0);
                    $pagination = null ;

                    return $this->render('frontend/recherche_annonce_villa.html.twig',[
                        'villas'        => $villas,
                        'pagination'    => $pagination,
                        'typebien'    => $typebien,
                        'biens'    => $biens,
                    ]);

                }else{
                    $autrebiens = $em->getRepository('AppBundle:AnnonceAutrebien')
                        ->findAutrebien($typebien, $whereZone, $whereMin, $whereMax, $localisation, $mode, $min, $max)
                    ;
                    $biens = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $typebiens->getId()), null, 9, 0);
                    $pagination = null ;

                    return $this->render('frontend/recherche_autrebien.html.twig',[
                        'autrebiens'        => $autrebiens,
                        'pagination'    => $pagination,
                        'typebien'    => $typebien,
                        'biens'    => $biens,
                    ]);
                }

            }elseif ($localisation){
                //$mode = 'Location'; //die($min);

                // Formulation de la requete du prix
                //if ($min){ $whereMin = 'b.prix >= :min'; }else { $whereMin = 'b.prix >= :min'; $min = 0;}
                //if ($max){ $whereMax = 'b.prix <= :max'; } else{ $whereMax = 'b.prix <= :max'; $max = 1000000000; }
                if ($min and $max){
                    $wherePrix = 'b.prix BETWEEN :min and :max';
                }elseif ($min and !$max){
                    $wherePrix = 'b.prix BETWEEN :min and :max';
                    $max = 1000000000;
                }elseif (!$min and $max){
                    $wherePrix = 'b.prix BETWEEN :min and :max';
                    $min = 0;
                }else{
                    $wherePrix = 'b.prix BETWEEN :min and :max';
                    $min = 0; $max = 1000000000;
                }
                $localite = $em->getRepository('AppBundle:Zone')->findOneBy(['libelle'=>$localisation]);
                $zones = $em->getRepository('AppBundle:AnnonceBien')->findBienZone($localisation, $wherePrix, $min, $max, $mode, 9, 0);
                $biens = $em->getRepository('AppBundle:AnnonceBien')->findBy(['zone'=>$localite->getId()], null, 9, 0);
                $pagination = null ;

                return $this->render('frontend/recherche_annonce_zone.html.twig',[
                    'zones'        => $zones,
                    'pagination'    => $pagination,
                    'localisation'    => $localisation,
                    'biens' => $biens,
                ]);
            }else{
                $autrebiens = $em->getRepository('AppBundle:AnnonceBien')->findListDesc();
                return $this->render('frontend/recherche_annoncebien.html.twig',[
                    'biens' => $autrebiens,
                    'pagination' => null
                ]);
            }

        }else{
            $autrebiens = $em->getRepository('AppBundle:AnnonceBien')->findListDesc();
            return $this->render('frontend/recherche_annoncebien.html.twig',[
                'biens' => $autrebiens,
                'pagination' => null
            ]);
        }
    }

    /**
     * Recherche de la vente et location par le formulaire
     *
     * @Route("/achat/immo/neuf", name="rfrontend_achat")
     * @Method("GET")
     */
    public function achatAction(Request $request, Utilities $utilities)
    {
        $session = new Session();
        $mode = $request->get('Mode'); //dump($mode);die();

        $typebien = $request->get('typebien');
        $piece = $request->get('piece');
        $localisation = $request->get('localisation');
        $min = $request->get('minimum');
        $max = $request->get('maximum');

        if ($mode === 'Location'){
            $session->set('typebien', $typebien);
            $session->set('piece', $piece);
            $session->set('localisation', $localisation);
            $session->set('min', $min);
            $session->set('max', $max);

            $session->set('mode', 'Location');

            return $this->redirectToRoute('rfrontend_location');
        }


        $em = $this->getDoctrine()->getManager();

        if ($typebien or $piece or $localisation){
            // Si le type de bien est selectionné veifier
            // sinon verifier uniquement la localite
            if ($typebien){
                //$mode = 'Vente';
                $typebiens = $em->getRepository('AppBundle:Typebien')->findOneBy(array('libelle'=> $typebien));
                $resume = $utilities->resume($typebiens->getSlug(), 5, '', true);
                $nbPiece = $utilities->resume($piece, 1, '', true);

                //Test d'existence de la zone et formaulation de la requête
                if ($localisation){
                    $whereZone = 'z.libelle = :localite';
                } else{
                    $whereZone = 'z.libelle <> :localite';
                    $localisation = 'a';
                }

                // Formulation de la requete du prix
                if ($min){ $whereMin = 'b.prix >= :min'; }else { $whereMin = 'b.prix >= :min'; $min = 0;}
                if ($max){ $whereMax = 'b.prix <= :max'; } else{ $whereMax = 'b.prix <= :max'; $max = 1000000000; }

                // Verification du type de bien puis renvoie a la page correspondante a ce type de bien
                if ($resume === 'immeu'){
                    // Formulation de la requete du nombre de pièce
                    if (!$nbPiece){
                        $wherePiece = 'i.appartement > :piece'; $nbPiece = 0;
                    } elseif ($nbPiece <= 5){ $wherePiece = 'i.appartement = :piece'; } else{ $wherePiece = 'i.appartement > :piece'; $nbPiece = 5;}

                    $immeubles = $em->getRepository('AppBundle:Immeuble')
                        ->findImmeuble($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece, 9, 0)
                    ;
                    $biens = $em->getRepository('AppBundle:Bien')->findBy(array('typebien' => $typebiens->getId()), ['flag'=>'DESC'], 9, 0);
                    $pagination = null ;

                    $annonceImmeubles = $em->getRepository('AppBundle:AnnonceImmeuble')
                        ->findImmeuble($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
                    ;//dump($annonceImmeubles);die();
                    $annonceBiens = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $typebiens->getId()), null, 9, 0);

                    return $this->render('frontend/recherche_immeuble.html.twig',[
                        'immeubles'        => $immeubles,
                        'annonceImmeubles'        => $annonceImmeubles,
                        'pagination'    => $pagination,
                        'typebien'    => $typebien,
                        'biens'    => $biens,
                        'annonceBiens'    => $annonceBiens,
                    ]);

                }elseif ($resume === 'appar'){
                    // Formulation de la requete du nombre de pièce
                    if (!$nbPiece){
                        $wherePiece = 'a.piece > :piece'; $nbPiece = 0;
                    } elseif ($nbPiece <= 5){ $wherePiece = 'a.piece = :piece'; } else{ $wherePiece = 'a.piece > :piece'; $nbPiece = 5;}

                    $appartements = $em->getRepository('AppBundle:Appartement')
                        ->findAppartement($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
                    ;
                    $biens = $em->getRepository('AppBundle:Bien')->findBy(array('typebien' => $typebiens->getId(), 'statut'=>1), ['flag'=>'DESC'], 9, 0);
                    $pagination = null ;

                    $annonceAppartements = $em->getRepository('AppBundle:AnnonceAppartement')
                        ->findAppartement($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
                    ; //dump($mode);die();
                    $annonceBiens = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $typebiens->getId(), 'statut'=>1), null, 9, 0);

                    return $this->render('frontend/recherche_appartement.html.twig',[
                        'appartements'        => $appartements,
                        'annonceAppartements'        => $annonceAppartements,
                        'pagination'    => $pagination,
                        'typebien'    => $typebien,
                        'biens'    => $biens,
                        'annonceBiens'    => $annonceBiens,
                    ]);

                }elseif ($resume === 'villa'){ //dump($typebiens);die();
                    // Formulation de la requete du nombre de pièce
                    if (!$nbPiece){
                        $wherePiece = 'v.piece > :piece'; $nbPiece = 0;
                    } elseif ($nbPiece <= 5){ $wherePiece = 'v.piece = :piece'; } else{ $wherePiece = 'v.piece > :piece'; $nbPiece = 5;}

                    $villas = $em->getRepository('AppBundle:Villa')->findVilla($typebiens->getId(), $whereZone, $whereMin, $whereMax, $wherePiece, $mode, $localisation, $min, $max, $nbPiece);

                    $biens = $em->getRepository('AppBundle:Bien')->findBy(array('typebien' => $typebiens->getId(), 'statut'=>1), ['flag'=>'DESC'], 9, 0);
                    $pagination = null ;

                    // Annonce
                    $annonceVillas = $em->getRepository('AppBundle:AnnonceVilla')
                        ->findVilla($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
                    ;
                    $annonceBiens = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $typebiens->getId(), 'statut'=>1), null, 9, 0);

                    return $this->render('frontend/recherche_villa.html.twig',[
                        'villas'        => $villas,
                        'annonceVillas'        => $annonceVillas,
                        'pagination'    => $pagination,
                        'typebien'    => $typebien,
                        'biens'    => $biens,
                        'annonceBiens'    => $annonceBiens,
                    ]);

                }else{
                    $autrebiens = $em->getRepository('AppBundle:Autrebien')
                        ->findAutrebien($typebien, $whereZone, $whereMin, $whereMax, $localisation, $mode, $min, $max)
                    ;
                    $biens = $em->getRepository('AppBundle:Bien')->findBy(array('typebien' => $typebiens->getId(), 'statut'=>1), ['flag'=>'DESC'], 9, 0);
                    $pagination = null ;

                    // Annonce
                    $annonceAutrebiens = $em->getRepository('AppBundle:AnnonceAutrebien')
                        ->findAutrebien($typebien, $whereZone, $whereMin, $whereMax, $localisation, $mode, $min, $max)
                    ;
                    $annonceBiens = $em->getRepository('AppBundle:AnnonceBien')->findBy(array('typebien' => $typebiens->getId(), 'statut'=>1), null, 9, 0);

                    return $this->render('frontend/recherche_autrebien.html.twig',[
                        'autrebiens'        => $autrebiens,
                        'annonceAutrebiens'        => $annonceAutrebiens,
                        'pagination'    => $pagination,
                        'typebien'    => $typebien,
                        'biens'    => $biens,
                        'annonceBiens'    => $annonceBiens,
                    ]);
                }

                $biens = $em->getRepository('AppBundle:Bien')->findBienR($typebiens->getId(), $whereZone, $localisation);

                dump($biens);die();

            }elseif ($localisation){
                //$mode = 'Vente'; //die($min);

                // Formulation de la requete du prix
                //if ($min){ $whereMin = 'b.prix >= :min'; }else { $whereMin = 'b.prix >= :min'; $min = 0;}
                //if ($max){ $whereMax = 'b.prix <= :max'; } else{ $whereMax = 'b.prix <= :max'; $max = 1000000000; }
                if ($min and $max){
                    $wherePrix = 'b.prix BETWEEN :min and :max';
                }elseif ($min and !$max){
                    $wherePrix = 'b.prix BETWEEN :min and :max';
                    $max = 1000000000;
                }elseif (!$min and $max){
                    $wherePrix = 'b.prix BETWEEN :min and :max';
                    $min = 0;
                }else{
                    $wherePrix = 'b.prix BETWEEN :min and :max';
                    $min = 0; $max = 1000000000;
                }

                $zones = $em->getRepository('AppBundle:Bien')->findBienZone($localisation, $wherePrix, $min, $max, $mode, 9, 0);
                $biens = $em->getRepository('AppBundle:Bien')->findDernierBienEnPromo(0,9);
                $pagination = null; //dump($zones);die();

                return $this->render('frontend/recherche_zone.html.twig',[
                    'zones'        => $zones,
                    'pagination'    => $pagination,
                    'localisation'    => $localisation,
                    'biens'    => $biens,
                ]);
            }else{
                $biens = $em->getRepository('AppBundle:Bien')->findListActif();

                return $this->render('frontend/recherche_bien.html.twig',[
                    'biens' => $biens,
                    'pagination' => null,
                ]);
            }

        }else{
            $biens = $em->getRepository('AppBundle:Bien')->findListActif();

            return $this->render('frontend/recherche_bien.html.twig',[
                'biens' => $biens,
                'pagination' => null,
            ]);
        }
    }
}
