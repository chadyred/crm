<?php

namespace Enigmatic\CRMBundle\Controller;

use Enigmatic\CRMBundle\Entity\Agency;
use Enigmatic\CRMBundle\Form\AgencyType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Default:index.html.twig', array()));
    }

    public function getUserWelcomeAction() {
        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Default:welcome.html.twig', array(
            'user'  => $this->get('enigmatic_crm.manager.user')->getCurrent(),
        )));
    }
}
