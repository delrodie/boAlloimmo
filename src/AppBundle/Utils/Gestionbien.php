<?php

namespace AppBundle\Utils;


use Doctrine\ORM\EntityManager;

class Gestionbien
{
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * Suppresion du bien
     */
    public function suppression($bienId)
    {
        $bien = $this->em->getRepository('AppBundle:Bien')->findOneBy(['id'=>$bienId]);
        if ($bien){
            $this->em->remove($bien);
            $this->em->flush();

            return true;
        }else{
            return false;
        }
    }

    /**
     * Modification du champ fille de bien
     */
    public function miseajour($bienId)
    {
        $bien = $this->em->getRepository('AppBundle:Bien')->findOneBy(['id'=>$bienId]);
        if ($bien){
            $bien->setStatut(true);
            $this->em->persist($bien);
            $this->em->flush();

            return true;
        }else{
            return false;
        }
    }

    /**
     * Interaction du nombre de vues
     */
    public function vue($bienId)
    {
        $bien = $this->em->getRepository("AppBundle:Bien")->findOneBy(['id'=>$bienId]);
        if ($bien){
            $vue = $bien->getVue() + 1;
            $bien->setVue($vue);
            $this->em->flush();

            return true;
        }else{
            return false;
        }
    }
}
