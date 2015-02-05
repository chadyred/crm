<?php

namespace Enigmatic\CityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * City
 *
 * @ORM\Table(name="city_city")
 * @ORM\Entity(repositoryClass="Enigmatic\CityBundle\Repository\CityRepository")
 */
class City
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Department
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CityBundle\Entity\Department", inversedBy="cities")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $department;

    /**
     * @var string
     *
     * @ORM\Column(name="canonical_name", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $canonicalName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="zipcode", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max=255)
     */
    private $zipcode;

    /**
     * @var integer
     *
     * @ORM\Column(name="population", type="integer")
     * @Assert\NotNull()
     * @Assert\Range(min=0)
     */
    private $population;

    /**
     * @var integer
     *
     * @ORM\Column(name="area", type="integer")
     * @Assert\NotNull()
     * @Assert\Range(min=0)
     */
    private $area;

    /**
     * @var float
     *
     * @ORM\Column(name="longitude", type="float")
     * @Assert\NotNull()
     */
    private $longitude;

    /**
     * @var float
     *
     * @ORM\Column(name="latitude", type="float")
     * @Assert\NotNull()
     */
    private $latitude;

    /**
     * Constructor
     */
    public function __construct($canonicalName = null, $name = null, $zipcode = null, $population = null, $area = null, $longitude = null, $latitude = null, $department = null)
    {
        $this->canonicalName = $canonicalName;
        $this->name = $name;
        $this->zipcode = $zipcode;
        $this->population = $population;
        $this->area = $area;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->department = $department;
    }

    /**
     * toString
     */
    public function __toString() {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set canonicalName
     *
     * @param string $canonicalName
     * @return City
     */
    public function setCanonicalName($canonicalName)
    {
        $this->canonicalName = $canonicalName;

        return $this;
    }

    /**
     * Get canonicalName
     *
     * @return string 
     */
    public function getCanonicalName()
    {
        return $this->canonicalName;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return City
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     *
     * @return string 
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }

    /**
     * Get canonicalZipcode
     *
     * @return string
     */
    public function getCanonicalZipcode()
    {
        return (strlen($this->getZipcode())>5)?substr($this->getZipcode(), 0, 4).'0':$this->getZipcode();
    }

    /**
     * Set population
     *
     * @param integer $population
     * @return City
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer 
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set area
     *
     * @param integer $area
     * @return City
     */
    public function setArea($area)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return integer 
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return City
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return City
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }



    /**
     * Set department
     *
     * @param \Enigmatic\CityBundle\Entity\Department $department
     * @return City
     */
    public function setDepartment(\Enigmatic\CityBundle\Entity\Department $department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \Enigmatic\CityBundle\Entity\Department 
     */
    public function getDepartment()
    {
        return $this->department;
    }
}
