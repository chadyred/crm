<?php

namespace Enigmatic\CityBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Department
 *
 * @ORM\Table(name="city_department")
 * @ORM\Entity
 */
class Department
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
     * @var string
     *
     * @ORM\Column(name="code", type="string")
     * @Assert\NotNull()
     * @Assert\Length(max=3, min=2)
     */
    private $code;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Enigmatic\CityBundle\Entity\Region", inversedBy="departments")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank()
     * @Assert\Length(max=100)
     */
    private $name;

    /**
     * @var City
     *
     * @ORM\OneToMany(targetEntity="Enigmatic\CityBundle\Entity\City", mappedBy="department", cascade={"all"})
     */
    private $cities;

    /**
     * Constructor
     */
    public function __construct($code = null, $name = null, $region = null)
    {
        $this->code = $code;
        $this->name = $name;
        $this->cities = new \Doctrine\Common\Collections\ArrayCollection();
        $this->region = $region;
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
     * Set code
     *
     * @param string $code
     * @return Department
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Department
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
     * Set region
     *
     * @param \Enigmatic\CityBundle\Entity\Region $region
     * @return Department
     */
    public function setRegion(\Enigmatic\CityBundle\Entity\Region $region)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Enigmatic\CityBundle\Entity\Region 
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Add cities
     *
     * @param \Enigmatic\CityBundle\Entity\City $cities
     * @return Department
     */
    public function addCity(\Enigmatic\CityBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \Enigmatic\CityBundle\Entity\City $cities
     */
    public function removeCity(\Enigmatic\CityBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCities()
    {
        return $this->cities;
    }
}
