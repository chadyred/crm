<?php
namespace Enigmatic\CRMBundle\Mailer;

use Doctrine\ORM\EntityManagerInterface;
use Enigmatic\CRMBundle\Entity\User;
use Enigmatic\MailerBundle\Services\MailerService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class UserMailer
{
    protected $em;
    protected $mailer;
    protected $templating;

    /**
     * @param EntityManagerInterface $entityManager
     * @param MailerService $mailer
     * @param EngineInterface $templating
     */
    public function __construct(EntityManagerInterface $entityManager, MailerService $mailer, EngineInterface $templating)
    {
        $this->em = $entityManager;
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param User $user
     * @param string $password
     */
    public function newUser(User $user, $password)
    {
        $renderedTemplate = $this->templating->render('EnigmaticCRMBundle:User:Email/register.html.twig', array(
            'user'       => $user,
            'password'   => $password
        ));

        $this->mailer->sendMail($user->getEmail(), $renderedTemplate);
    }

}