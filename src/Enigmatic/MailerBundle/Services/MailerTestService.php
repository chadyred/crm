<?php
namespace Enigmatic\MailerBundle\Services;

use Enigmatic\MailerBundle\Model\Transport;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class MailerTestService
{
    protected $mailer;
    protected $templating;

    public function __construct(MailerService $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param $email_to
     * @param string $mailer_alias
     * @return bool
     */
    public function sendTest($email_to, $mailer_alias = 'default')
    {
        return $this->mailer->sendMail($email_to, $this->templating->render('EnigmaticMailerBundle:Default:test.html.twig'), $mailer_alias);
    }

}