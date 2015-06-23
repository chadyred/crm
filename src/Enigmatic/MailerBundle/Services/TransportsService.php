<?php
namespace Enigmatic\MailerBundle\Services;

use Enigmatic\MailerBundle\Model\Transport;
use Monolog\Logger;

class TransportsService
{
    private $transports;
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->transports = array();
        $this->logger = $logger;
    }

    public function addTransport(Transport $transport, $alias)
    {
        $this->transports[$alias] = $transport;
    }

    public function getTransport($alias)
    {
        if (array_key_exists($alias, $this->transports))
            return $this->transports[$alias];
        elseif (array_key_exists('default', $this->transports)) {
            $this->logger->warn("Unable to find alias '$alias' in list of mailer. Default mailer used.");
            return $this->transports['default'];
        }

        return null;
    }
}