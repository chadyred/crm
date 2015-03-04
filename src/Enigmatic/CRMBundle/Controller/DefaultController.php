<?php

namespace Enigmatic\CRMBundle\Controller;

use Enigmatic\CRMBundle\Entity\Agency;
use Enigmatic\CRMBundle\Form\AgencyType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $activities = array();
        $_activities = $this->get('enigmatic_crm.manager.activity')->getAll();
        foreach ($_activities as $activity) {
            if (isset($activities[$activity->getUser()->getId()][$activity->getType()->getType()]))
                $activities[$activity->getUser()->getId()][$activity->getType()->getType()] ++;
            else
                $activities[$activity->getUser()->getId()][$activity->getType()->getType()] = 1;
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Default:index.html.twig', array()));
    }

    public function getUserWelcomeAction() {
        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Default:welcome.html.twig', array(
            'user'  => $this->get('enigmatic_crm.manager.user')->getCurrent(),
        )));
    }
}
