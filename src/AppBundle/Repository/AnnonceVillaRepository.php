<?php

namespace AppBundle\Repository;

/**
 * AnnonceVillaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnnonceVillaRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Recherche des villa
     * findVilla($typebien, $limit, $offset)
     */
    public function findVilla($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
    { //die($mode);
        return $this->createQueryBuilder('v')
            ->addSelect('b')
            ->addSelect('z')
            ->addSelect('m')
            ->innerJoin('v.annoncebien', 'b')
            ->innerJoin('b.typebien', 't')
            ->innerJoin('b.zone', 'z')
            ->innerJoin('b.mode', 'm')
            ->where('t.libelle = :typebien')
            ->andWhere($whereZone)
            ->andWhere($whereMin)
            ->andWhere($whereMax)
            ->andWhere($wherePiece)
            ->andWhere('m.libelle = :mode')
            ->andWhere('b.statut = 1')
            ->andWhere('b.fille = 1')
            ->setParameters(array(
                'typebien'  => $typebien,
                'localite'  => $localisation,
                'min'       => $min,
                'max'       => $max,
                'piece'     => $nbPiece,
                'mode'      => $mode,
            ))
            ->getQuery()->getResult()
            ;
    }
}
