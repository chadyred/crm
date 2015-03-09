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
        if ($params['date_start']) {
            $params['date_start'] = \DateTime::createFromFormat('d-m-Y H:i:s', substr($params['date_start'], 0, 10) . '00:00:00');
            if (!$params['date_start'])
                $params['date_start'] = null;
        }
        elseif ($params['date_start'] === null)
            $params['date_start'] = (new \DateTime())->modify('-1 month');
        else
            $params['date_start'] = null;

        $params['user'] = array();
        if (count($this->get('request')->request->get('user')))
            foreach($this->get('request')->request->get('user') as $uid)
                $params['user'][$uid] = $uid;

        $params['agency'] = array();
        if (count($this->get('request')->request->get('agency')))
            foreach($this->get('request')->request->get('agency') as $aid)
                $params['agency'][$aid] = $aid;

        if ($this->get('security.authorization_checker')->isGranted('ROLE_RCA') && !$this->get('security.authorization_checker')->isGranted('ROLE_RS'))
            $params['agency'][$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency()->getId()] = $this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency()->getId();
        elseif ($this->get('security.authorization_checker')->isGranted('ROLE_CA') && !$this->get('security.authorization_checker')->isGranted('ROLE_RCA'))
            $params['user'][$this->get('enigmatic_crm.manager.user')->getCurrent()->getId()] = $this->get('enigmatic_crm.manager.user')->getCurrent()->getId();


//        if ($this->get('request')->request->get('total'))
//            $params['total'] = true;
//        else
            $params['total'] = true;

        $params['date_end'] = $this->get('request')->request->get('date_end');
        if ($params['date_end']) {
            $params['date_end'] = \DateTime::createFromFormat('d-m-Y H:i:s', substr($params['date_end'], 0, 10).'00:00:00');
            if (!$params['date_end'])
                $params['date_end'] = null;
            else
                $params['date_end']->modify('+23 hours +59 min +59 sec');
        }
        elseif ($params['date_end'] === null)
            $params['date_end'] = (new \DateTime());
        else
            $params['date_end'] = null;

        $users = $this->get('enigmatic_crm.manager.user')->getAll();

        $agencies = array();
        foreach ($this->get('enigmatic_crm.manager.agency')->getAll() as $agency) {
            foreach ($agency->getAccounts() as $agency_account) {
                $agencies[$agency_account->getAgency()->getId()][$agency_account->getAccount()->getId()]['potential'] = $agency_account->getPotential();
            }
        }

        $activities = array();
        $activities_agency = array();
        $activities_total = array();
        $activities_graph = array();
        foreach ($this->get('enigmatic_crm.manager.activity')->getAllByDate($params['date_start'], $params['date_end']) as $activity) {
            // User
            $this->incrementVar($activities[$activity->getUser()->getId()][$activity->getType()->getType()]);
            // Agency
            $this->incrementVar($activities_agency[$activity->getUser()->getAgency()->getId()][$activity->getType()->getType()]['total']);
            // Total
            $this->incrementVar($activities_total[$activity->getType()->getType()]['total']);

            // ByDay
            $this->incrementVar($activities_graph[$activity->getDateStart()->format('Y-m-d')]['total']);
            $this->incrementVar($activities_graph[$activity->getDateStart()->format('Y-m-d')][$activity->getUser()->getId()]);
            $this->incrementVar($activities_graph[$activity->getDateStart()->format('Y-m-d')]['agency'][$activity->getUser()->getAgency()->getId()]);
            // ByMonth
            $this->incrementVar($activities_graph[$activity->getDateStart()->format('Y').'-'.intval($activity->getDateStart()->format('m'))]['total']);
            $this->incrementVar($activities_graph[$activity->getDateStart()->format('Y').'-'.intval($activity->getDateStart()->format('m'))][$activity->getUser()->getId()]);
            $this->incrementVar($activities_graph[$activity->getDateStart()->format('Y').'-'.intval($activity->getDateStart()->format('m'))]['agency'][$activity->getUser()->getAgency()->getId()]);

        }

        $accounts_onwers = array();
        $accounts_onwers_agency = array();
        $accounts_onwers_total = array();
        foreach ($this->get('enigmatic_crm.manager.account_owner')->getAllByDate($params['date_start'], $params['date_end']) as $account_onwer) {
            $potential = null;
            if (isset($agencies[$account_onwer->getUser()->getAgency()->getId()][$account_onwer->getAccount()->getId()]))
                $potential = $agencies[$account_onwer->getUser()->getAgency()->getId()][$account_onwer->getAccount()->getId()];
            if ($potential) {
                // User
                $this->incrementVar($accounts_onwers[$account_onwer->getUser()->getId()][$potential['potential']]);
                if ($account_onwer->getUser()->hasRole('ROLE_RS') == false) {
                    // Agency
                    $this->incrementVar($accounts_onwers_agency[$account_onwer->getUser()->getAgency()->getId()][$potential['potential']]);
                    // Total
                    $this->incrementVar($accounts_onwers_total[$potential['potential']]);
                }

            }
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Default:index.html.twig', array(
            'users'                     => $users,
            'agencies'                  => $this->get('enigmatic_crm.manager.agency')->getAll(),
            'activities'                => $activities,
            'activities_agency'         => $activities_agency,
            'activities_total'          => $activities_total,
            'activities_graph'          => $activities_graph,
            'accounts_onwers'           => $accounts_onwers,
            'accounts_onwers_agency'    => $accounts_onwers_agency,
            'accounts_onwers_total'     => $accounts_onwers_total,
            'params'                    => $params,
            'current_agency'            => $this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null,
            'current_user'              => $this->get('enigmatic_crm.manager.user')->getCurrent(),
            'colors'                    => array('#e94b3b', '#f98e33', '#23ae89','#2ec1cc', '#7c78ca', '#8BC000', '#638FC0', '#45207E', '#7E1455', '#1B7E67', '#6B7E2D', '#7E5A2D',
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
