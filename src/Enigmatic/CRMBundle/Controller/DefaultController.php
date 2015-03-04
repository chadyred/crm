<?php

namespace Enigmatic\CRMBundle\Controller;

use Enigmatic\CRMBundle\Entity\Agency;
use Enigmatic\CRMBundle\Form\AgencyType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $params['date_start'] = $this->get('request')->request->get('date_start');
        if ($params['date_start'])
            $params['date_start'] = \DateTime::createFromFormat('d-m-Y H:i', $params['date_start']);
        else
            $params['date_start'] = null;

        $params['date_end'] = $this->get('request')->request->get('date_end');
        if ($params['date_end'])
            $params['date_end'] = \DateTime::createFromFormat('d-m-Y H:i', $params['date_end']);
        else
            $params['date_end'] = null;

        $users = $this->get('enigmatic_crm.manager.user')->getAll();

        $activities = array();
        foreach ($this->get('enigmatic_crm.manager.activity')->getAllByDate($params['date_start'], $params['date_end']) as $activity) {
            $this->incrementVar($activities[$activity->getUser()->getId()][$activity->getType()->getType()]);
        }

        $agencies = array();
        foreach ($this->get('enigmatic_crm.manager.agency')->getAll() as $agency) {
            foreach ($agency->getAccounts() as $agency_account) {
                $agencies[$agency_account->getAgency()->getId()][$agency_account->getAccount()->getId()]['potential'] = $agency_account->getPotential();
            }
        }

        $accounts_onwers = array();
        foreach ($this->get('enigmatic_crm.manager.account_owner')->getAllByDate($params['date_start'], $params['date_end']) as $account_onwer) {
            $potential = null;
            if (isset($agencies[$account_onwer->getUser()->getAgency()->getId()][$account_onwer->getAccount()->getId()]))
                $potential = $agencies[$account_onwer->getUser()->getAgency()->getId()][$account_onwer->getAccount()->getId()];
            if ($potential) {
                $this->incrementVar($accounts_onwers[$account_onwer->getUser()->getId()][$potential['potential']]);
            }
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Default:index.html.twig', array(
            'activities'        => $activities,
            'users'             => $users,
            'agencies'          => $this->get('enigmatic_crm.manager.agency')->getAll(),
            'accounts_onwers'   => $accounts_onwers,
            'params'            => $params,
        )));
    }

    public function getUserWelcomeAction() {
        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Default:welcome.html.twig', array(
            'user'  => $this->get('enigmatic_crm.manager.user')->getCurrent(),
        )));
    }



    protected function incrementVar(&$var) {
        if (isset($var))
            $var++;
        else
            $var = 1;
    }
}
