<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;

class Gestionannonce
{
    function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function maj($bienSlug)
    {
        $bien = $this->em->getRepository('AppBundle:AnnonceBien')->findOneBy(['slug'=>$bienSlug]);

        if ($bien){
            $bien->setFille(true);
            $this->em->persist($bien);
            $this->em->flush();

            return true;
        }else{
            return false;
        }
    }

    public function suppression($bienId)
    {
        $bien = $this->em->getRepository('AppBundle:AnnonceBien')->findOneBy(['id'=>$bienId]);
        if ($bien){
            $slug = $bien->getTypebienslug();
            if ($slug === 'villa'){
                $villa = $this->em->getRepository('AppBundle:AnnonceVilla')->findOneBy(['annoncebien'=> $bien->getId()]);
                if ($villa){
                    $this->em->remove($villa);
                    $this->em->flush();

                    $this->em->remove($bien);
                    $this->em->flush();

                    return true;
                }else{
                    return false;
                }
            }elseif($slug === 'immeu'){
                $immeuble = $this->em->getRepository('AppBundle:AnnonceImmeuble')->findOneBy(['annoncebien'=>$bien->getId()]);
                if ($immeuble){
                    $this->em->remove($immeuble);
                    $this->em->flush();

                    $this->em->remove($bien);
                    $this->em->flush();
                    return true;

                }else{
                    return false;
                }
            }elseif ($slug === 'appar'){
                $appartement = $this->em->getRepository('AppBundle:AnnonceAppartement')->findOneBy(['annoncebien'=>$bien->getId()]);
                if ($appartement){
                    $this->em->remove($appartement);
                    $this->em->flush();

                    $this->em->remove($bien);
                    $this->em->flush();
                    return true;
                }else{
                    return false;
                }
            }else{
                $autrebien = $this->em->getRepository('AppBundle:AnnonceAutrebien')->findOneBy(['annoncebien'=>$bien->getId()]);
                if ($autrebien){
                    $this->em->remove($autrebien);
                    $this->em->flush();

                    $this->em->remove($bien);
                    $this->em->flush();
                    return true;
                }else{
                    return false;
                }
            }
        }
    }
}
