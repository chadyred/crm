<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccountStatusException;

class RegistrationController extends Controller
{
    public function confirmAction($token)
    {
        $user = $this->container->get('fos_user.user_manager')->findUserByConfirmationToken($token);
        if ($user) {
            $user->setConfirmationToken(null);
            $user->setEnabled(true);
            $user->setLastLogin(new \DateTime());
            $this->container->get('fos_user.user_manager')->updateUser($user);
            $response = new RedirectResponse($this->container->get('router')->generate('user_confirmation'));
            $this->authenticateUser($user, $response);
            $this->get('session')->getFlashBag()->add('success', sprintf('Votre compte est désormais actif'));
        }
        else
            $response = new RedirectResponse($this->container->get('router')->generate('user_confirmation'));

        return $response;
    }

    protected function authenticateUser(UserInterface $user, Response $response)
    {
        try {
            $this->container->get('fos_user.security.login_manager')->loginUser(
                $this->container->getParameter('fos_user.firewall_name'),
                $user,
                $response);
        } catch (AccountStatusException $ex) {
            // We simply do not authenticate users which do not pass the user
            // checker (not enabled, expired, etc.).
        }
    }
}