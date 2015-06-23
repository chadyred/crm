<?php

namespace Enigmatic\CityBundle\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Enigmatic\CityBundle\Entity\City;

class CityTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an id to a City Objet.
     *
     * @param  City|null $city
     * @return int
     */
    public function transform($city)
    {
        if (null === $city)
            return "";

        return $city->getId();
    }

    /**
     * Transforms a integer (id) to an Objet (city).
     *
     * @param  int $id
     * @return City $city|null
     * @throws TransformationFailedException if object (city) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id)
            return null;



        $city = $this->om
            ->getRepository('EnigmaticCityBundle:City')
            ->findOneBy(array('id' => $id))
        ;

        if (null === $city)
            throw new TransformationFailedException(sprintf(
                'This city cannot be found',
                $id
            ));

        return $city;
    }
}