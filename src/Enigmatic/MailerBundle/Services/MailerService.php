<?php
namespace Enigmatic\MailerBundle\Services;

use Enigmatic\MailerBundle\Model\Transport;

class MailerService
{
    protected $mailers;
    protected $logger;

    protected $attachs;

    public function __construct(TransportsService $mailers)
    {
        $this->mailers = $mailers;
        $this->attachs = array();
    }

    public function addAttach($attach_path = null, $attach_filename = null) {
        $this->attachs[] = \Swift_Attachment::fromPath($attach_path)->setFilename($attach_filename);
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

        $subject = $renderedLines[1];
        $body = implode("\n", array_slice($renderedLines, 2, -1));

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

        $errors = null;
        $mailer->getMailer()->send($message, $errors);

        return $errors;
    }

}