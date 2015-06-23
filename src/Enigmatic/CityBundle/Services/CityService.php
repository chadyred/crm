<?php

namespace Enigmatic\CityBundle\Services;

class CityService
{
    /**
     * @param Array $cities
     * @return Array
     */
    public function formatForSearch ($cities) {

        $tab_cities = array();
        foreach ($cities as $city) {
            $tab_cities[] = array(
                'id'            => $city->getId(),
                'name'          => $city->getName(),
                'zipcode'       => $city->getCanonicalZipcode(),
                'department'    => $city->getDepartment()->getName()
            );
        }

        return $tab_cities;
    }

    /**
     * @param $lat1
     * @param $lon1
     * @param $lat2
     * @param $lon2
     * @return Float
     */
    public function getDistance($lat1, $lon1, $lat2, $lon2) {
        return (6371*acos(cos(deg2rad($lat1 / 1000))*cos(deg2rad($lat2 / 1000))*cos(deg2rad($lon2 / 1000) - deg2rad($lon1 / 1000))+sin(deg2rad($lat1 / 1000))*sin(deg2rad($lat2 / 1000))));
    }
}
