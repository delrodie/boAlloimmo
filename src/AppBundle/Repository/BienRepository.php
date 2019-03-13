<?php

namespace AppBundle\Repository;

/**
 * BienRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BienRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Recherche du bien par son ID pour AutrebienType.php
     */
    public function findBien($bien)
    {
        return $q = $this->createQueryBuilder('b')
                         ->where('b.id = :id')
                         ->setParameter('id', $bien)
            ;
    }

    /**
     * Liste des bien par ordre decroissant
     */
    public function findAllDesc($partenaire = null)
    {
        if ($partenaire){
           return $this->createQueryBuilder('b')
                        ->leftJoin('b.partenaire','p')
                        ->where('p.slug LIKE :slug')
                        ->orderBy('b.id', 'DESC')
                        ->setParameter('slug', $partenaire)
                        ->getQuery()->getResult()
                ;
        }else{
            return $q = $this->createQueryBuilder('b')
                ->orderBy('b.id', 'DESC')
                ->getQuery()->getResult()
                ;
        }
    }

    /**
     * Liste d'un certains nombres de bien
     */
    public function findListBien($offset, $limit)
    {
        return $q = $this->QueryBien()
                         ->where('b.statut = 1')
                         ->setFirstResult($offset)
                         ->setMaxResults($limit)
                         ->getQuery()->getResult()
            ;
    }

    /**
     * Bien en publicité
     */
    public function findBienEnPromo($offset, $limit)
    {
        return $q = $this->createQueryBuilder('b')
                         ->where('b.statut = 1')
                         ->andWhere('b.datedebut <= :date')
                         ->andWhere('b.datefin >= :date')
                         ->orderBy('b.flag', 'DESC')
                         ->addOrderBy('b.datedebut', 'ASC')
                         ->setFirstResult($offset)
                         ->setMaxResults($limit)
                         ->setParameters(array(
                             'date' => date('Y-m-d', time())
                         ))
                         ->getQuery()->getResult()
            ;
    }

    /**
     * Liste des derniers bien et en promotion
     */
    public function findDernierBienEnPromo($limit, $offset)
    {
        return $q = $this->QueryBien()
                         ->addOrderBy('b.flag', 'DESC')
                         ->addOrderBy('b.promotion', 'ASC')
                         ->setFirstResult($offset)
                         ->setMaxResults($limit)
                         ->getQuery()->getResult()
            ;
    }

    /**
     * Liste des biens du partenaires
     */
    public function findBienPartenaire($partenaire, $limit=null, $offset=null)
    {
        return $this->QueryBien()
                    ->innerJoin('b.partenaire', 'p')
                    ->where('p.slug = :partenaire')
                    ->addOrderBy('b.flag', 'DESC')
                    ->addOrderBy('b.promotion', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->setParameter('partenaire', $partenaire)
                    ->getQuery()->getResult();
            ;
    }

    /**
     *
     */
    public function findBienR($typebien, $whereZone, $localisation)
    {
        if (!$localisation) $localisation = null; //ump($localisation);die();
        return $q = $this->createQueryBuilder('b')
                    ->innerJoin('b.zone', 'z')
                    ->where('b.typebien = :typebien')
                    ->orderBy('b.flag', 'DESC')
                    ->andWhere($whereZone)
                    ->setParameters(array(
                        'typebien' => $typebien,
                        'localite'  => $localisation,
                    ))
                    ->getQuery()->getResult();
            ;

    }

    /**
     * Liste des biens selon la zone
     */
    public function findBienZone($localisation, $wherePrix, $min, $max, $mode, $limit, $offset)
    {
        return $this->QueryBien()
                    ->innerJoin('b.zone', 'z')
                    ->innerJoin('b.mode', 'm')
                    ->where('z.libelle = :zone')
                    ->andWhere('m.libelle = :mode')
                    ->andWhere($wherePrix)
                    ->addOrderBy('b.flag', 'DESC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
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
     * Liste des biens actifs pour la zone recherce
     * Ordonné par ordre decroissant de Flag
     * Utilisé dans FRechercheController(AchatAction)
     */
    public function findListActif()
    {
        return $this->createQueryBuilder('b')
                    ->where('b.statut = 1')
                    ->orderBy('b.flag', 'DESC')
                    ->getQuery()->getResult()
            ;
    }

    /**
     * recherche de bien par type de bien
     */
    public function findByTypebien($typebien)
    {
        return $this->createQueryBuilder('b')
                    ->leftJoin('b.typebien', 't')
                    ->where('t.slug = :typebien')
                    ->orderBy('b.id', 'DESC')
                    ->setParameter('typebien', $typebien)
                    ->getQuery()->getResult()
            ;
    }

    /**
     * fonction de recherche
     */
    public function QueryBien()
    {
        return $q = $this->createQueryBuilder('b')
                         ->orderBy('b.id', 'DESC')
            ;
    }

    /**
     * Fonction de calcul du nombre de bien
     */
    public function calcul()
    {
        return $this->createQueryBuilder('b')->select('count(b.id)')->where('b.statut = 1');
    }
}
