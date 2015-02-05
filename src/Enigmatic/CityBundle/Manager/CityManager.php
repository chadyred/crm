<?php

namespace Enigmatic\CityBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CityBundle\Entity\City;

class CityManager
{
    protected $em;
    protected $class;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager) {
        $this->em  = $entityManager;
        $this->class = 'EnigmaticCityBundle:City';
    }

    /**
     * @return City
     */
    public function create() {
        return new City();
    }

    /**
     * @param City $city
     * @param bool $flush
     * @return City
     */
    public function save(City $city, $flush = true) {
        $this->em->persist($city);
        if ($flush)
            $this->em->flush();

        return $city;
    }

    /**
     * @param City $city
     * @param bool $flush
     * @return City
     */
    public function remove(City $city, $flush = true) {
        $this->em->remove($city);
        if ($flush)
            $this->em->flush();

        return $city;
    }

    /**
     * @param int $id
     * @return City
     */
    public function get($id) {
        return$this->em->getRepository($this->class)->findOneById($id);
    }

    /**
     * @param string $zipcode
     * @return City
     */
    public function getByZipcode($zipcode) {
        return$this->em->getRepository($this->class)->findOneByZipcode($zipcode);
    }

    /**
     * @return Array
     */
    public function getAll() {
        return $this->em->getRepository($this->class)->findAll();
    }

    /**
     * @param string $search
     * @return Array
     */
    public function search($search = '', $limit = 10) {
        return $this->em->getRepository($this->class)->search($search, $limit);
    }
}
