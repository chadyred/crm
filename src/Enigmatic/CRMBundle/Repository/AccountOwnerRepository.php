<?php

namespace Enigmatic\CRMBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\Agency;

/**
 * AccountOwnerRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AccountOwnerRepository extends EntityRepository
{
    public function findByAccountAndAgency(Account $account, Agency $agency) {

        $qb = $this->createQueryBuilder('account_owner');
        $qb ->where('account_owner.account = :account')
            ->setParameter('account', $account);

        $qb ->leftjoin('account_owner.user', 'user')
            ->addSelect('user')
            ->leftjoin('user.agencies', 'user_agencies')
            ->addSelect('user_agencies')
            ->leftjoin('account_owner.end', 'account_owner_end')
            ->addSelect('account_owner_end')
            ->andWhere('user_agencies.agency = :agency')
            ->andWhere('account_owner_end.dateEnd IS NULL')
            ->setParameter('agency', $agency);

        return $qb->getQuery()->getResult();
    }

    public function findAllByDate(\DateTime $from = null, \DateTime $to = null) {

        $qb = $this->createQueryBuilder('account_owner');
        if ($from)
            $qb ->andWhere('account_owner.dateCreated >= :from')
                ->setParameter('from', $from->format('Y-m-d H:i:s'));
        if ($to)
            $qb ->andWhere('account_owner.dateCreated < :to')
                ->setParameter('to', $to->format('Y-m-d H:i:s'));

        $qb ->leftjoin('account_owner.end', 'account_owner_end')
            ->andWhere('account_owner_end.dateEnd IS NULL');

        return $qb->getQuery()->getResult();
    }
}
