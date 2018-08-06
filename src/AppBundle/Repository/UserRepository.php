<?php

namespace AppBundle\Repository;

/**
 * UserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UserRepository extends \Doctrine\ORM\EntityRepository
{
    public function findUser($id)
    {
        return $this->createQueryBuilder('u')
                    ->where('u.id = :id')
                    ->setParameter('id', $id)
        ;
    }
}
