<?php

namespace Enigmatic\CRMBundle\Command;

use Enigmatic\CRMBundle\Entity\ActivityType;
use Enigmatic\CRMBundle\Entity\CampaignFaxing;
use Enigmatic\CRMBundle\Entity\CampaignMailing;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendCampaignsCommand extends ContainerAwareCommand
{
    private $dueDate;

    protected function configure()
    {
        $this
            ->setName('enigmatic:send-campaign')
            ->setDescription('Send waiting campaign')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $this->getContainer()->getParameter('kernel.environment');
        $output->writeln('<comment>Send mailing on <info>'.$env.'</info> environnment</comment>');

        // MAILING
        $campaigns = $this->getContainer()->get('enigmatic_crm.manager.campaign_mailing')->getByState(CampaignMailing::CAMPAIGN_MAILING_WAITING);
        $nb_campaign_send = 0;
        foreach ($campaigns as $campaign) {
            if (count($campaign->getContacts())) {
                if ($campaign->getDateSended() <= new \DateTime()) {
                    $nb_campaign_send++;
                    foreach ($campaign->getContacts() as $contact) {
                        if ($contact->getEmail()) {

                            $mail = $this->getContainer()->get('enigmatic_mailer');
                            $i = 1;
                            if (count($campaign->getFiles()))
                                foreach ($campaign->getFiles() as $file) {
                                    $mail->addAttach($file->getAbsolutePath(), 'pj' . $i .'.'.substr(strrchr($file->getPath(),'.'), 1));
                                    $i++;
                                }

                            $mail->sendMail($contact->getEmail(), $this->getContainer()->get('templating')->render('EnigmaticCRMBundle:CampaignMailing:Email/mailing.html.twig', array(
                                    'subject' => $campaign->getEmailSubject(),
                                    'content' => $campaign->getEmailBody())
                            ), 'spool');

                            if ($activity_type = $this->getContainer()->get('enigmatic_crm.manager.activity_type')->getByName('campaign_mailing')) {
                                $activity = $this->getContainer()->get('enigmatic_crm.manager.activity')->create($contact->getAccount(), null, $campaign->getOwner(), $activity_type);
                                $activity->setDateEnd((new \DateTime())->modify('+5 min'));
                                $this->getContainer()->get('enigmatic_crm.manager.activity')->save($activity);
                            }

                            if ($activity_type = $this->getContainer()->get('enigmatic_crm.manager.activity_type')->getByName('call_relance')) {
                                $activity = $this->getContainer()->get('enigmatic_crm.manager.activity')->create($contact->getAccount(), null, $campaign->getOwner(), $activity_type);
                                $date_activity = $this->getNextDueDate();
                                $activity->setDateStart($date_activity);
                                $activity->setDateEnd(clone $date_activity->modify('+15 min'));
                                $this->getContainer()->get('enigmatic_crm.manager.activity')->save($activity);
                            }
                        }
                    }
                }
            }
            $campaign->setState(CampaignMailing::CAMPAIGN_MAILING_SENDED);
            $this->getContainer()->get('enigmatic_crm.manager.campaign_mailing')->save($campaign);
        }
        $output->writeln('<info>'.$nb_campaign_send.'</info> Campaigns mailing send');

        // FAXING
        if ($this->getContainer()->getParameter('enigmatic_crm.ecofax.login') && $this->getContainer()->getParameter('enigmatic_crm.ecofax.password')) {
            $campaigns = $this->getContainer()->get('enigmatic_crm.manager.campaign_faxing')->getByState(CampaignFaxing::CAMPAIGN_FAXING_WAITING);
            $nb_campaign_send = 0;
            foreach ($campaigns as $campaign) {
                if (count($campaign->getContacts())) {
                    if ($campaign->getDateSended() <= new \DateTime()) {
                        $nb_campaign_send++;
                        foreach ($campaign->getContacts() as $contact) {
                            if ($contact->getFax()) {

                                $mail = $this->getContainer()->get('enigmatic_mailer');
                                $i = 1;
                                foreach ($campaign->getFaxs() as $fax) {
                                    $mail->addAttach($fax->getAbsolutePath(), 'fax' . $i . '.pdf');
                                    $i++;
                                }

                                $num_fax = $contact->getFax();
                                if (strlen($num_fax) == 12)
                                    $num_fax = '00'.substr($num_fax, 1, 12);
                                else
                                    $num_fax = '0033'.substr($num_fax, 1, 10);

                                $mail->sendMail($num_fax . '@ecofax.fr', $this->getContainer()->get('templating')->render('EnigmaticCRMBundle:CampaignFaxing/Email:faxing.html.twig', array(
                                        'subject' => $this->getContainer()->getParameter('enigmatic_crm.ecofax.login'),
                                        'content' => $this->getContainer()->getParameter('enigmatic_crm.ecofax.password'))
                                ), 'spool');

                                if ($activity_type = $this->getContainer()->get('enigmatic_crm.manager.activity_type')->getByName('campaign_faxing')) {
                                    $activity = $this->getContainer()->get('enigmatic_crm.manager.activity')->create($contact->getAccount(), null, $campaign->getOwner(), $activity_type);
                                    $activity->setDateEnd((new \DateTime())->modify('+5 min'));
                                    $this->getContainer()->get('enigmatic_crm.manager.activity')->save($activity);
                                }

                                if ($activity_type = $this->getContainer()->get('enigmatic_crm.manager.activity_type')->getByName('call_relance')) {
                                    $activity = $this->getContainer()->get('enigmatic_crm.manager.activity')->create($contact->getAccount(), null, $campaign->getOwner(), $activity_type);
                                    $date_activity = $this->getNextDueDate();
                                    $activity->setDateStart($date_activity);
                                    $activity->setDateEnd(clone $date_activity->modify('+15 min'));
                                    $this->getContainer()->get('enigmatic_crm.manager.activity')->save($activity);
                                }
                            }
                        }
                    }
                }
                $campaign->setState(CampaignFaxing::CAMPAIGN_FAXING_SENDED);
                $this->getContainer()->get('enigmatic_crm.manager.campaign_faxing')->save($campaign);
            }
            $output->writeln('<info>' . $nb_campaign_send . '</info> Campaigns faxing send');
        }
        else
            $output->writeln('Campaigns faxing is not configured');


        exec('php app/console swiftmailer:spool:send --message-limit=50 --env='.$env);

    }

    protected function getNextDueDate() {

        if ($this->dueDate instanceof \DateTime) {
            $this->dueDate->modify('+20 minutes');
        }
        else {
            $this->dueDate = \Datetime::createFromFormat('Y-m-d H:i:s', date('Y-m-d').'09:00:00');
            $this->dueDate->modify('+3 days');
        }

        if ($this->dueDate->format('D') == 'Sun' || $this->dueDate->format('D') == 'Sat')
            return $this->getNextDueDate();
        elseif ($this->dueDate->format('H') < 9 || $this->dueDate->format('H') >= 17 || ($this->dueDate->format('H') >= 12 && $this->dueDate->format('H') < 14))
            return $this->getNextDueDate();

        return $this->dueDate;
    }
}