<?php

namespace Enigmatic\CRMBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EnigmaticCRMBundle:Default:index.html.twig');
    }
}
