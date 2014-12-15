<?php

namespace Enigmatic\OROMailingBundle\Command;

use Enigmatic\OROMailingBundle\Entity\Campaign;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendMailingCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('enigmatic:oromailing:send-mailing')
            ->setDescription('Envois des mailings en attente')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $this->getContainer()->getParameter('kernel.environment');
        $output->writeln('<comment>Send mailing on <info>'.$env.'</info> environnment</comment>');

        $campaigns = $this->getContainer()->get('doctrine')->getManager()->getRepository('EnigmaticOROMailingBundle:Campaign')->findByState(Campaign::CAMPAIGN_MAILING_WAITING);
        $nb_campaign_send = 0;
        foreach ($campaigns as $campaign) {
            if ($campaign->getDateSended() <= new \DateTime()) {
                $nb_campaign_send ++;
                foreach ($campaign->getContacts() as $contact) {
                    $this->getContainer()->get('enigmatic_mailer')->sendMail($contact->getContact()->getEmail(), $this->getContainer()->get('templating')->render('EnigmaticOROMailingBundle:Email:mailing.html.twig', array(
                        'subject' => $campaign->getEmailSubject(),
                        'content' => $campaign->getEmailBody())
                    ), 'spool');
                }

                $campaign->setState(Campaign::CAMPAIGN_MAILING_SENDED);
                $this->getContainer()->get('doctrine')->getManager()->flush();
            }
        }

        exec('php app/console swiftmailer:spool:send --message-limit=50 --env='.$env);

        $output->writeln('<info>'.$nb_campaign_send.'</info> Campaigns send');
    }
}