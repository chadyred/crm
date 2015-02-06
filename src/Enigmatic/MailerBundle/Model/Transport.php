<?php

namespace Enigmatic\MailerBundle\Model;

class Transport
{
    protected $mailer;
    protected $sender;
    protected $email_from;

    public function __construct($mailer, $email_from, $sender)
    {
        $this->mailer = $mailer;
        $this->sender = $sender;
        $this->email_from = $email_from;
    }

    /**
     * @return mixed
     */
    public function getEmailFrom()
    {
        return $this->email_from;
    }

    /**
     * @param mixed $email_from
     */
    public function setEmailFrom($email_from)
    {
        $this->email_from = $email_from;
    }

    /**
     * @return mixed
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @param mixed $sender
     */
    public function setSender($sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return \Swift_Mailer
     */
    public function getMailer()
    {
        return $this->mailer;
    }

    /**
     * @param \Swift_Mailer $mailer
     */
    public function setMailer(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

}