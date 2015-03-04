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
        elseif ($params['date_start'] === null)
            $params['date_start'] = (new \DateTime())->modify('-1 month');
        else
            $params['date_start'] = null;

        $params['date_end'] = $this->get('request')->request->get('date_end');
        if ($params['date_end'])
            $params['date_end'] = \DateTime::createFromFormat('d-m-Y H:i', $params['date_end']);
        elseif ($params['date_end'] === null)
            $params['date_end'] = (new \DateTime());
        else
            $params['date_end'] = null;

        $users = $this->get('enigmatic_crm.manager.user')->getAll();

        $g_activities_rs = array();
        $g_activities_rca = array();
        $g_activities_ca = array();
        $activities = array();
        foreach ($this->get('enigmatic_crm.manager.activity')->getAllByDate($params['date_start'], $params['date_end']) as $activity) {
            $this->incrementVar($activities[$activity->getUser()->getId()][$activity->getType()->getType()]);
            $this->incrementVar($g_activities_rs[$activity->getType()->getType()][$activity->getType()->getTitle()]);
            $this->incrementVar($g_activities_rca[$activity->getUser()->getAgency()->getId()][$activity->getType()->getType()][$activity->getType()->getTitle()]);
            $this->incrementVar($g_activities_ca[$activity->getUser()->getId()][$activity->getType()->getType()][$activity->getType()->getTitle()]);
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
            'g_activities_rs'   => $g_activities_rs,
            'g_activities_rca'  => $g_activities_rca,
            'g_activities_ca'   => $g_activities_ca,
            'users'             => $users,
            'agencies'          => $this->get('enigmatic_crm.manager.agency')->getAll(),
            'accounts_onwers'   => $accounts_onwers,
            'params'            => $params,
            'current_agency'    => $this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null,
            'current_user'      => $this->get('enigmatic_crm.manager.user')->getCurrent(),
            'colors'            => array('#00C015', '#5076C0', '#C00303','#C00EB7', '#512FC0', '#8BC000', '#638FC0', '#45207E', '#7E1455', '#1B7E67', '#6B7E2D', '#7E5A2D',
                '#203D7E', '#7E2A5B', '#597E76', '#3A0D13', "#203A24", "#3A3607", "#BB70E5", "#964842")
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
