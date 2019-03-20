<?php

namespace AppBundle\Repository;

/**
 * AutrebienRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AutrebienRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Recherche des immeubles
     */
    public function findAutrebien($typebien, $whereZone, $whereMin, $whereMax, $localisation, $mode, $min, $max)
    { //die($mode);
        return $this->createQueryBuilder('a')
            ->addSelect('b')
            ->addSelect('z')
            ->addSelect('m')
            ->innerJoin('a.bien', 'b')
            ->innerJoin('b.typebien', 't')
            ->innerJoin('b.zone', 'z')
            ->innerJoin('b.mode', 'm')
            ->where('t.libelle = :typebien')
            ->andWhere($whereZone)
            ->andWhere($whereMin)
            ->andWhere($whereMax)
            ->andWhere('m.libelle = :mode')
            ->andWhere('b.satut = 1')
            ->orderBy('b.flag', 'DESC')
            ->setParameters(array(
                'typebien'  => $typebien,
                'localite'  => $localisation,
                'min'       => $min,
                'max'       => $max,
                'mode'      => $mode,
            ))
            ->getQuery()->getResult()
            ;
    }
}
