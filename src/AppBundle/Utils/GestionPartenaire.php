<?php

namespace AppBundle\Utils;

use Doctrine\ORM\EntityManager;

class GestionPartenaire
{
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    // Interaction du nombre de vues
    public function vue($partenaireId)
    {
        $partenaire = $this->em->getRepository("AppBundle:Partenaire")->findOneBy(['id'=>$partenaireId]);
        if ($partenaire){
            $vue = $partenaire->getVue() + 1;
            $partenaire->setVue($vue);
            $this->em->flush();

            return true;
        }else{
            return false;
        }
    }
}