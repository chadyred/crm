<?php
namespace Enigmatic\MailerBundle\Services;

use Enigmatic\MailerBundle\Model\Transport;
use Monolog\Logger;

class MailerService
{
    protected $mailers;
    protected $attachs;
    protected $logger;
    protected $dkimDomain;

    public function __construct(TransportsService $mailers, Logger $logger, $dkimDomain = null)
    {
        $this->mailers = $mailers;
        $this->logger = $logger;
        $this->dkimDomain = $dkimDomain;
        $this->attachs = array();
    }

    /**
     * @param $email_to
     * @param $rendered_template
     * @param string $mailer_alias
     * @return bool
     * @throws \Exception
     */
    public function sendMail($email_to, $rendered_template, $mailer_alias = 'default')
    {
        $mailer = $this->mailers->getTransport($mailer_alias);
        if (!$mailer instanceof Transport)
            throw new \Exception('This mailer in not a instance of Enigmatic\MailerBundle\Model\Transport.');

        $renderedLines = explode("\n", trim($rendered_template));

        $subject = $renderedLines[0];
        $body = implode("\n", array_slice($renderedLines, 1));

        $tab_from = explode('@', $mailer->getEmailFrom());
        $tab_to = explode('@', $email_to);
        $return_path = $tab_from[0].'+'.$tab_to[0].'-'.$tab_to[1].'@'.$tab_from[1];

        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setSender($mailer->getEmailFrom(), $mailer->getSender())
            ->setFrom($mailer->getEmailFrom(), $mailer->getSender())
            ->setReturnPath($return_path)
            ->setTo($email_to)
            ->setBody($body, 'text/html');

        foreach ($this->attachs as $attach) {
            $message->attach($attach);
        }

        if ($this->dkimDomain)
            $message->attachSigner(new \Swift_Signers_DKIMSigner(__DIR__ . '../Ressources/keys/enigmatic.dkim.private.key', $this->dkimDomain, 'default'));


        $this->logger->info('Send mail to : '.$email_to);

        $errors = null;
        $mailer->getMailer()->send($message, $errors);

        return $errors;
    }

    /**
     * @param string $attach_path
     * @param string $attach_filename
     * @return MailerService
     */
    public function addAttach($attach_path = null, $attach_filename = null) {
        $this->attachs[] = \Swift_Attachment::fromPath($attach_path)->setFilename($attach_filename);
        return $this;
    }

}