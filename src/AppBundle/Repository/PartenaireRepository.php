<?php

namespace AppBundle\Repository;

/**
 * PartenaireRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PartenaireRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Liste des partenaires par ordre alphabetiques
     */
    public function getListeAsc()
    {
        return $this->createQueryBuilder('p')
                    ->orderBy('p.nom', 'ASC')
                    ->getQuery()->getResult()
            ;
    }

    /**
     * Liste des partenaires selon le service
     */
    public function findListePartenaireBy($service, $limit, $offset)
    {
        return $this->createQueryBuilder('p')
                    ->innerJoin('p.services', 's')
                    ->where('s.slug = :service')
                    ->orderBy('p.nom', 'ASC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->setParameter('service', $service)
                    ->getQuery()->getResult();
            ;
    }

    /**
     * Liste des partenaires selon le domaine
     */
    public function findListePartenaireByDomaine($slug, $limit, $offset)
    {
        return $this->createQueryBuilder('p')
                    ->innerJoin('p.services', 's')
                    ->innerJoin('s.domaine', 'd')
                    ->where('d.slug = :slug')
                    ->orderBy('p.nom', 'ASC')
                    ->setFirstResult($offset)
                    ->setMaxResults($limit)
                    ->setParameter('slug', $slug)
                    ->getQuery()->getResult()
            ;
    }
}
