<?php

namespace Enigmatic\OROFaxingBundle\Command;

use Enigmatic\OROFaxingBundle\Entity\Campaign;
use OroCRM\Bundle\TaskBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendFaxingCommand extends ContainerAwareCommand
{
    private $dueDate;

    protected function configure()
    {
        $this
            ->setName('enigmatic:orofaxing:send-faxing')
            ->setDescription('Envois des faxing en attente')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $env = $this->getContainer()->getParameter('kernel.environment');
        $output->writeln('<comment>Send faxing on <info>'.$env.'</info> environnment</comment>');

        $organisation = $this->getContainer()->get('doctrine')->getManager()->getRepository('OroOrganizationBundle:Organization')->find(1);
        $task_priority = $this->getContainer()->get('doctrine')->getManager()->getRepository('OroCRMTaskBundle:TaskPriority')->findOneByName('low');
        $owner = $this->getContainer()->get('doctrine')->getManager()->getRepository('OroUserBundle:User')->find(1);

        $campaigns = $this->getContainer()->get('doctrine')->getManager()->getRepository('EnigmaticOROFaxingBundle:Campaign')->findByState(Campaign::CAMPAIGN_FAXING_WAITING);
        $nb_campaign_send = 0;
        foreach ($campaigns as $campaign) {
            if (count($campaign->getContacts() && count($campaign->getFax()))) {
                if ($campaign->getDateSended() <= new \DateTime()) {
                    $nb_campaign_send++;
                    foreach ($campaign->getContacts() as $campaign_contact) {

                        if ($campaign_contact->getContact()->getFax()) {
                            $mail = $this->getContainer()->get('enigmatic_mailer');
                            $i = 1;
                            foreach ($campaign->getFax() as $fax) {
                                $mail->addAttach($fax->getFaxAbsolutePath(), 'fax' . $i . '.pdf');
                                $i++;
                            }
                            $mail->sendMail(/*$campaign_contact->getContact()->getFax() . '@ecofax.fr'*/ 'rp@enigmatic.fr', $this->getContainer()->get('templating')->render('EnigmaticOROFaxingBundle:Email:mailing.html.twig', array(
                                    'subject' => $this->getContainer()->getParameter('enigmatic_oro_faxing.login'),
                                    'content' => $this->getContainer()->getParameter('enigmatic_oro_faxing.password'))
                            ), 'spool');

                            $task = new Task();
                            $task->setCreatedAt(new \DateTime());
                            $task->setDescription('Faxing : '.$campaign->getName());
                            $task->setDueDate($this->getNextDueDate());
                            $task->setRelatedContact($campaign_contact->getContact());
                            $task->setSubject('Envoie d\'un faxing');
                            $task->setUpdatedAt(new \DateTime());
                            $task->setOrganization($organisation);
                            $task->setOwner($owner);
                            $task->setTaskPriority($task_priority);
                            $task->setReporter($owner);

                            if (count($campaign_contact->getContact()->getAccounts()))
                                $task->setRelatedAccount($campaign_contact->getContact()->getAccounts()->first());

                            $this->getContainer()->get('doctrine')->getManager()->persist($task);
                            $this->getContainer()->get('doctrine')->getManager()->flush();
                        }
                    }

//                    $campaign->setState(Campaign::CAMPAIGN_FAXING_SENDED);
                    $this->getContainer()->get('doctrine')->getManager()->flush();
                }
            }
        }

        exec('php app/console swiftmailer:spool:send --message-limit=50 --env='.$env);

        $output->writeln('<info>'.$nb_campaign_send.'</info> Campaigns send');
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