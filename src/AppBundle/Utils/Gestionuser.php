<?php


namespace AppBundle\Utils;

use AppBundle\Controller\ErrorController;
use Doctrine\ORM\EntityManager;

class Gestionuser
{
    public function __construct(EntityManager $entityManager, ErrorController $errorController)
    {
        $this->em = $entityManager;
        $this->error = $errorController;
    }

    /**
     * Suppression de l'utilisateur
     */
    public function suppression($userId)
    {
        $utilisateur = $this->em->getRepository('AppBundle:Utilisateur')->findOneBy(['user'=>$userId]);
        if ($utilisateur){ dump($utilisateur);die();
            return $this->error->utilisateurAction($utilisateur->getId());
        }
        $user = $this->em->getRepository('AppBundle:User')->findOneBy(['id'=>$userId]);
    }
}
