<?php

namespace Enigmatic\CRMBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * ActivityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ActivityRepository extends EntityRepository
{
    public function getList($page = 0, $listPageLimit = null, $params = array(), $replanned = false) {

        $qb = $this->createQueryBuilder('activity');

        $qb = $this->join($qb, true);
        if (isset($params['search']))
            $qb = $this->search($qb, $params['search']);
        if (isset($params['order']))
            $qb = $this->order($qb, $params['order']);
        $qb = $this->isReplanned($qb, $replanned);

        $qb ->getQuery();

        if ($listPageLimit) {
            $qb ->setFirstResult($page * $listPageLimit)
                ->setMaxResults($listPageLimit);
        }

        return new Paginator($qb);
    }

    public function find($id) {

        $qb = $this->createQueryBuilder('activity');
        $qb = $this->join($qb, true);
        $qb ->where('activity = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function findAllByDate(\DateTime $from = null, \DateTime $to = null, $params = array(), $replanned = false) {

        $qb = $this->createQueryBuilder('activity');
        $qb = $this->join($qb, true);
        if ($from)
            $qb ->andWhere('activity.dateStart >= :from or activity.dateEnd >= :from')
                ->setParameter('from', $from->format('Y-m-d H:i:s'));
        if ($to)
            $qb ->andWhere('activity.dateStart < :to or activity.dateEnd < :to')
                ->setParameter('to', $to->format('Y-m-d H:i:s'));
        if (isset($params['search']))
            $qb = $this->search($qb, $params['search']);
        if (isset($params['order']))
            $qb = $this->order($qb, $params['order']);
        $qb = $this->isReplanned($qb, $replanned);

        return $qb->getQuery()->getResult();
    }

    protected function join(QueryBuilder $qb, $add = false)
    {
        $qb->leftjoin('activity.account', 'account');
        $qb->leftjoin('activity.user', 'user');
        $qb->leftjoin('activity.replanned', 'replanned');
        $qb->leftjoin('activity.replannedBy', 'replannedBy');
        $qb->leftjoin('activity.type', 'type');

        if ($add) {
            $qb->addSelect('account');
            $qb->addSelect('user');
            $qb->addSelect('replanned');
            $qb->addSelect('replannedBy');
            $qb->addSelect('type');
        }

        return $qb;
    }

    protected function search(QueryBuilder $qb, $searchs)
    {
        if (is_array($searchs)) {
            foreach ($searchs as $field => $value) {
                if ($value) {
                    switch ($field) {
                        case 'id':
                            $qb ->andWhere('activity.id = :search_id');
                            $qb ->setParameter('search_id', $value);
                            break;
                        case 'type':
                            $qb ->andWhere('type.title LIKE :search_type');
                            $qb ->setParameter('search_type', '%'.$value.'%');
                            break;
                        case 'type_type':
                            $qb ->andWhere('type.type = :search_type_type');
                            $qb ->setParameter('search_type_type', $value);
                            break;
                        case 'account_name':
                            $qb ->andWhere('account.name LIKE :search_account_name');
                            $qb ->setParameter('search_account_name', '%'.$value.'%');
                            break;
                        case 'user_name':
                            $qb ->andWhere('user.name LIKE :search_user_name OR user.firstname LIKE :search_user_name');
                            $qb ->setParameter('search_user_name', '%'.$value.'%');
                            break;
                        case 'user':
                            $qb ->andWhere('user = :search_user');
                            $qb ->setParameter('search_user', $value);
                            break;
                        case 'dateStart':
                            $value = \DateTime::createFromFormat('d-m-Y H:i:s', $value.':00');
                            $qb ->andWhere('activity.dateStart >= :search_date_start');
                            $qb ->setParameter('search_date_start', $value);
                            break;
                        case 'dateStartEnd':
                            $value = \DateTime::createFromFormat('d-m-Y H:i:s', $value.':00');
                            $qb ->andWhere('activity.dateStart < :search_date_end');
                            $qb ->setParameter('search_date_end', $value);
                            break;
                        case 'comment':
                            $qb ->andWhere('activity.comment LIKE :search_comment');
                            $qb ->setParameter('search_comment', '%'.$value.'%');
                            break;
                        case 'account':
                            $qb ->andWhere('account = :search_account');
                            $qb ->setParameter('search_account', $value);
                            break;
                        case 'agency':
                            $qb ->leftjoin('user.agencies', 'user_agencies');
                            $qb ->leftjoin('user_agencies.end', 'user_agencies_end');
                            $qb ->andWhere('user_agencies.agency = :search_agency');
                            $qb ->andWhere('user_agencies.dateCreated <= activity.dateCreated');
                            $qb ->andWhere('user_agencies_end IS NULL OR user_agencies_end.dateEnd > activity.dateCreated');
                            $qb ->setParameter('search_agency', $value);
                            break;
                        case 'activity_account_owner':
                            $qb ->leftjoin('account.owners', 'account_owners');
                            $qb ->andWhere('account_owners.user = :search_activity_account_owner');
                            $qb ->setParameter('search_activity_account_owner', $value);
                            break;
                    }
                }
            }
        }

        return $qb;
    }

    protected function order(QueryBuilder $qb, $orders = null)
    {
        if (is_array($orders)) {
            if (count($orders)) {
                foreach ($orders as $field => $direction) {
                    if ($direction != 'ASC')
                        $direction = 'DESC';
                    switch ($field) {
                        case 'id':
                            $qb->addOrderBy('activity.id', $direction);
                            break;
                        case 'type':
                            $qb->addOrderBy('type.title', $direction);
                            break;
                        case 'account_name':
                            $qb->addOrderBy('account.name', $direction);
                            break;
                        case 'user_name':
                            $qb->addOrderBy('user.firstname', $direction);
                            $qb->addOrderBy('user.name', $direction);
                            break;
                        case 'dateStart':
                            $qb->addOrderBy('activity.dateStart', $direction);
                            break;
                    }
                }
            }
            else {
                $qb->addOrderBy('activity.dateStart', 'DESC');
            }
        }

        return $qb;
    }

    protected function isReplanned(QueryBuilder $qb, $replanned = false)
    {
        if (!$replanned)
            $qb->andWhere('activity.replanned IS NULL');

        return $qb;
    }
}
