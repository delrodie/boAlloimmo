<?php


namespace AppBundle\Utils;


use AppBundle\Entity\Mouchard;
use Doctrine\ORM\EntityManager;

class GestionMouchard
{
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /*
     * Enregistrement du mouchard
     *
     * Titre :
     * * 1- Creation de compte utilisateur
     * * 2- Enregistrement d'annonces
     * * 3- Modification d'annonces
     * * 4- Suppression d'annonces
     */
    public function createMouchard($username,$titre,$description,$lien)
    {
        // Si l'utilisateur et le titre existe alors pas d'enregistrement
        $verif = $this->em->getRepository('AppBundle:Mouchard')->findOneBy(['user'=>$username]);
        if ($verif){
            if ($username === $verif->getUser() AND $titre === $verif->getTitre()){
                return false;
            }
        }
        $mouchard = new Mouchard();
        $mouchard->setUser($username);
        $mouchard->setTitre($titre);
        $mouchard->setDescription($description);
        $mouchard->setLien($lien);
        $mouchard->setCreatedAt(date('Y-m-d h:i:s', time()));

        $this->em->persist($mouchard);
        $this->em->flush();

        return true;
    }

    /**
     * Changement de flag
     */
    public function changeFlag($id)
    {
        $mouchard = $this->em->getRepository('AppBundle:Mouchard')->findOneBy(['id'=> $id]);
        if ($mouchard){
            $mouchard->setFlag(true);
            $this->em->flush();

            return true;
        }else{
            return false;
        }
    }
}