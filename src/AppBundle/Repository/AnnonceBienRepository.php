<?php

namespace AppBundle\Repository;

/**
 * AnnonceBienRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnnonceBienRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * calcul du nombre de bien
     */
    public function cpteur($typebien)
    {
        return $this->createQueryBuilder('b')
                    ->select('count(b.id)')
                    ->where('b.typebien = :bien')
                    ->setParameter('bien', $typebien)
                    ->getQuery()->getSingleScalarResult()
            ;
    }

    public function findBien($bien)
    {
        return $this->createQueryBuilder('b')
                    ->where('b.slug = :bien')
                    ->setParameter('bien', $bien)
        ;
    }

    /**
     * Liste des annonces par ordre decroissant
     */
    public function findListAnnonce($user)
    {
        return $this->createQueryBuilder('b')
                    ->where('b.utilisateur = :user')
                    ->orderBy('b.id', 'DESC')
                    ->setParameter('user', $user)
                    ->getQuery()->getResult()
        ;
    }

    /**
     * Liste decroissante des annonces
     * Utiliser par
     *  - frontendController/AnnonceAction
     *  - FRechercheController/LocationAction
     */
    public function findListDesc($user = null){
        if ($user){
            return $this->createQueryBuilder('b')
                ->where('b.fille = 1')
                ->andWhere('b.statut = 1')
                ->andWhere('b.utilisateur = :user')
                ->orderBy('b.id', 'DESC')
                ->setParameter('user', $user)
                ->getQuery()->getResult()
                ;
        }
        return $this->createQueryBuilder('b')
                    ->where('b.fille = 1')
                    ->andWhere('b.statut = 1')
                    ->orderBy('b.id', 'DESC')
                    ->getQuery()->getResult()
            ;
    }

    /**
     * Liste des biens annonces
     */
    public function findListBien($limit = null, $offset = null)
    {
        if ($limit){
            return $this->createQueryBuilder('b')
                ->orderBy('b.id', 'DESC')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->getQuery()->getResult()
                ;
        }else{
            return $this->createQueryBuilder('b')->orderBy('b.id', 'DESC')->getQuery()->getResult();
        }
    }

    /**
     * liste des biens annonces par type de bien
     * use AnnonceBienController::index
     * use InternauteBienController::index
     */
    public function findByTypeBien($typebien, $user = null)
    {
        if ($user){
            return $this->createQueryBuilder('ab')
                        ->leftJoin('ab.typebien', 't')
                        ->where('t.slug = :typebien')
                        ->andWhere('ab.utilisateur = :user')
                        ->orderBy('t.id', 'DESC')
                        ->setParameters([
                            'typebien' =>  $typebien,
                            'user' => $user
                        ])
                        ->getQuery()->getResult()
                        ;
        }else{
            return $this->createQueryBuilder('ab')
                        ->leftJoin('ab.typebien', 't')
                        ->where('t.slug = :typebien')
                        ->orderBy('t.id', 'DESC')
                        ->setParameter('typebien', $typebien)
                        ->getQuery()->getResult()
                        ;
        }
    }

    /**
     * Recherche de bien selon la requette
     * use by annoncebienController:indexAction()
     * use InternauteBienController::indexAction
     */
    public function findBySearch($recherche, $user = null)
    {
        if ($user){
            return $this->createQueryBuilder('b')
                        ->leftJoin('b.typebien', 't')
                        ->leftJoin('b.mode', 'm')
                        ->leftJoin('b.utilisateur', 'u')
                        ->leftJoin('b.zone', 'z')
                        ->where('b.titre LIKE :recherche')
                        ->orWhere('b.description LIKE :recherche')
                        ->orWhere('b.prix LIKE :recherche')
                        ->orWhere('b.localisation LIKE :recherche')
                        ->orWhere('t.libelle LIKE :recherche')
                        ->orWhere('m.libelle LIKE :recherche')
                        ->orWhere('u.nom LIKE :recherche')
                        ->orWhere('z.libelle LIKE :recherche')
                        ->andWhere('b.utilisateur = :user')
                        ->orderBy('b.id', 'DESC')
                        ->setParameter([
                            'recherche'=> '%'.$recherche.'%',
                            'user' => $user
                        ])
                        ->getQuery()->getResult()
                        ;
        }else{
            return $this->createQueryBuilder('b')
                ->leftJoin('b.typebien', 't')
                ->leftJoin('b.mode', 'm')
                ->leftJoin('b.utilisateur', 'u')
                ->leftJoin('b.zone', 'z')
                ->where('b.titre LIKE :recherche')
                ->orWhere('b.description LIKE :recherche')
                ->orWhere('b.prix LIKE :recherche')
                ->orWhere('b.localisation LIKE :recherche')
                ->orWhere('t.libelle LIKE :recherche')
                ->orWhere('m.libelle LIKE :recherche')
                ->orWhere('u.nom LIKE :recherche')
                ->orWhere('z.libelle LIKE :recherche')
                ->orderBy('b.id', 'DESC')
                ->setParameter('recherche', '%'.$recherche.'%')
                ->getQuery()->getResult()
                ;
        }
    }

    /**
     * Liste des biens selon la zone
     */
    public function findBienZone($localisation, $wherePrix, $min, $max, $mode)
    {
        return $this->createQueryBuilder('b')
            ->innerJoin('b.zone', 'z')
            ->innerJoin('b.mode', 'm')
            ->where('z.libelle = :zone')
            ->andWhere('m.libelle = :mode')
            ->andWhere($wherePrix)
            ->setParameters(array(
                'zone'  => $localisation,
                'min'   => $min,
                'max'   => $max,
                'mode'  => $mode,
            ))
            ->getQuery()->getResult()
            ;
    }

    /**
     * Nombre d'annonces
     * use DefaultController:backendAction
     */
    public function cpteurAnnonce()
    {
        return $this->createQueryBuilder('ab')
                    ->select('count(ab.id)')
                    ->where('ab.statut = 1')
                    ->getQuery()->getSingleScalarResult()
            ;
    }

    /**
     * Liste des annonces les plus vues
     * use DefaultController:backendAction
     */
    public function findAnnoncePlusVues()
    {
        return $this->createQueryBuilder('ab')
                    ->where('ab.statut = 1')
                    ->orderBy('ab.vue', 'DESC')
                    ->setFirstResult(0)
                    ->setMaxResults(10)
                    ->getQuery()->getResult()
            ;
    }
}
