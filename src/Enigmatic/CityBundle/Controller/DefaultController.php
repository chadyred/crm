<?php

namespace Enigmatic\CityBundle\Controller;

use Enigmatic\CityBundle\Entity\City;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function getFormSearchAction($id_form_city, City $default_value = null, $options = array()) {
        return $this->render('EnigmaticCityBundle:Default:formSearch.html.twig', array(
            'id_form_city'  => $id_form_city,
            'default_value' => $default_value,
            'options'       => $options,
        ));
    }

    public function searchAction($search)
    {
        return new Response(json_encode(array(
            'success'   => true,
            'content'   => $this->get('enigmatic_city.service.city')->formatForSearch($this->get('enigmatic_city.manager.city')->search($search))
        )), 200, array('Content-Type' => 'application/json'));

    }
}
