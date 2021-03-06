<?php

namespace Enigmatic\CRMBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Enigmatic\CRMBundle\Entity\Account;

/**
 * AccountRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AccountRepository extends EntityRepository
{
    public function getList($page = 0, $listPageLimit = null, $params = array(), $states = array(Account::VALID)) {

        $qb = $this->createQueryBuilder('account');

        $qb = $this->join($qb, true);
        if (isset($params['search']))
            $qb = $this->search($qb, $params['search']);
        if (isset($params['order']))
            $qb = $this->order($qb, $params['order']);
        $qb = $this->state($qb, $states);

        $qb ->getQuery();

        if ($listPageLimit) {
            $qb ->setFirstResult($page * $listPageLimit)
                ->setMaxResults($listPageLimit);
        }

        return new Paginator($qb);
    }

    public function find($id) {

        $qb = $this->createQueryBuilder('account');
        $qb = $this->join($qb, true);
        $qb ->where('account = :id')
            ->setParameter('id', $id);

        return $qb->getQuery()->getOneOrNullResult();
    }

    public function getER($params = array(), $states = array(Account::VALID)) {

        $qb = $this->createQueryBuilder('account');

        $qb = $this->join($qb, true);
        if (isset($params['search']))
            $qb = $this->search($qb, $params['search']);
        if (isset($params['order']))
            $qb = $this->order($qb, $params['order']);
        $qb = $this->state($qb, $states);

        return $qb;
    }

    public function findByNameAndCity($name, $city) {

        $qb = $this->createQueryBuilder('account');
        $qb ->where('account.name = :name')
            ->andWhere('account.city = :city')
            ->setParameter('name', $name)
            ->setParameter('city', $city);
        $qb = $this->state($qb, array(Account::VALID));


        return $qb->getQuery()->getOneOrNullResult();
    }

    protected function join(QueryBuilder $qb, $add = false)
    {
        $qb->leftjoin('account.contacts', 'contacts');
        $qb->leftjoin('account.owners', 'owners');
        $qb->leftjoin('owners.end', 'owners_end');
        $qb->leftjoin('account.agencies', 'agencies');
        $qb->leftjoin('agencies.turnovers', 'turnovers');
        $qb->leftjoin('account.city', 'city');

        if ($add) {
            $qb->addSelect('contacts');
            $qb->addSelect('owners');
            $qb->addSelect('owners_end');
            $qb->addSelect('agencies');
            $qb->addSelect('turnovers');
            $qb->addSelect('city');
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
                            $qb ->andWhere('account.id = :search_id');
                            $qb ->setParameter('search_id', $value);
                            break;
                        case 'name':
                            $qb ->andWhere('account.name LIKE :search_name');
                            $qb ->setParameter('search_name', '%'.$value.'%');
                            break;
                        case 'potential':
                            $qb ->andWhere('agencies.potential = :search_potential');
                            $qb ->setParameter('search_potential', $value);
                            break;
                        case 'turnover':
                            $qb ->andWhere('turnovers.turnover = :search_turnover');
                            $qb ->setParameter('search_turnover', $value);
                            break;
                        case 'address_full':
                            $qb ->andWhere('account.address LIKE :search_address_full OR account.addressCpl LIKE :search_address_full OR city.canonicalName LIKE :search_address_full OR city.zipcode LIKE :search_address_full');
                            $qb ->setParameter('search_address_full', '%'.$value.'%');
                            break;
                        case 'phone':
                            $value = str_replace(' ', '', $value);
                            $qb ->andWhere('account.phone LIKE :search_phone');
                            $qb ->setParameter('search_phone', '%'.$value.'%');
                            break;
                        case 'agency':
                            $qb ->andWhere('agencies.agency = :search_agency');
                            $qb ->setParameter('search_agency', $value);
                            break;
                        case 'account_owner':
                            $qb ->andWhere('owners_end IS NULL');
                            $qb ->andWhere('owners.user = :search_owner');
                            $qb ->setParameter('search_owner', $value);
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
            foreach ($orders as $field => $direction) {
                if ($direction != 'ASC')
                    $direction = 'DESC';
                switch ($field) {
                    case 'id':
                        $qb ->addOrderBy('account.id', $direction);
                        break;
                    case 'name':
                        $qb ->addOrderBy('account.name', $direction);
                        break;
                }
            }
        }

        return $qb;
    }

    protected function state(QueryBuilder $qb, $states = array())
    {
        $i = 0;
        $cond = '';
        foreach ($states as $state) {
            if ($i != 0)
                $cond .= ' OR ';
            $i ++;
            $cond .= 'account.state = :state'.$i;
            $qb ->setParameter('state'.$i, $state);
        }

        $qb ->andwhere($cond);

        return $qb;
    }
}
