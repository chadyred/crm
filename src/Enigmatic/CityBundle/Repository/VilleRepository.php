<?php

namespace Enigmatic\CityBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CityRepository extends EntityRepository
{
    public function search($search, $limit = 10)
    {
        $qb = $this->createQueryBuilder('_city')
            ->where('_city.canonicalName LIKE :search')
            ->orWhere('_city.zipcode LIKE :search')
            ->setParameter('search', '%'.str_replace(' ', '-', $search).'%')
            ->orderBy('_city.population', 'DESC')
            ->setMaxResults($limit)
        ;

        return $qb->getQuery()->getResult();
    }

    public function findOneByZipcode($zipcode)
    {
        $qb = $this->createQueryBuilder('_city')
            ->orWhere('_city.zipcode LIKE :zipcode')
            ->setParameter('zipcode', '%'.$zipcode.'%')
            ->setMaxResults(1)
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
