<?php

namespace AppBundle\Repository;

/**
 * AnnonceImmeubleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AnnonceImmeubleRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Recherche des immeubles
     */
    public function findImmeuble($typebien, $whereZone, $whereMin, $whereMax, $wherePiece, $localisation, $mode, $min, $max, $nbPiece)
    { //die($mode);
        return $this->createQueryBuilder('i')
            ->addSelect('b')
            ->addSelect('z')
            ->addSelect('m')
            ->innerJoin('i.annoncebien', 'b')
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
                'piece'     => $nbPiece,
                'mode'      => $mode,
                'min'      => $min,
                'max'      => $max,
            ))
            ->getQuery()->getResult()
            ;
    }
}
