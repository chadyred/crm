<?php

namespace Enigmatic\CRMBundle\Controller;

use Enigmatic\CRMBundle\Entity\Agency;
use Enigmatic\CRMBundle\Form\AgencyType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{

    public function indexAction()
    {
        $content = $this->renderView('EnigmaticCRMBundle:Default:index.html.twig', array(
        ));

        return $this->get('enigmatic.render')->render($content);
    }
}
