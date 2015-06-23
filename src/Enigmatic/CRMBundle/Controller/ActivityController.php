<?php

namespace Enigmatic\CRMBundle\Controller;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\Activity;
use Enigmatic\CRMBundle\Entity\Agency;
use Enigmatic\CRMBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ActivityController extends Controller
{
    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function listAction(Account $account = null, $type = null, Agency $agency = null, User $user = null)
    {
        $params = $this->get('enigmatic_crm.service.list')->parseRequest($this->get('request')->request->all());

        if ($type)
            $params['search']['type_type'] = $type;
        if ($agency)
            $params['search']['agency'] = $agency;
        if ($user)
            $params['search']['user'] = $user;

        if ($this->get('security.authorization_checker')->isGranted('ROLE_RCA') && !$this->get('security.authorization_checker')->isGranted('ROLE_RS'))
            $params['search']['agency'] = ($this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null);
        elseif ($this->get('security.authorization_checker')->isGranted('ROLE_CA') && !$this->get('security.authorization_checker')->isGranted('ROLE_RS')) {
            $params['search']['agency'] = ($this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null);
            $params['search']['activity_account_owner'] = $this->get('enigmatic_crm.manager.user')->getCurrent();
        }
        if ($account)
            $params['search']['account'] = $account->getId();

        $activities = $this->get('enigmatic_crm.manager.activity')->getList($params['page'], $params['limit'], $params);
        $params['entity'] = 'Activity';
        $params['total'] = $activities->count();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Activity:list.html.twig', array(
            'activities'    => $activities,
            'params'        => $params,
            'account'       => $account,
            'calendar'      => true
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function calendarAction () {
        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Activity:calendar.html.twig'));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function calendarEventAction () {

        if (!isset($_GET['start']) || !isset($_GET['end']))
            throw new NotFoundHttpException();

        $params = array();
        if ($this->get('security.authorization_checker')->isGranted('ROLE_RCA') && !$this->get('security.authorization_checker')->isGranted('ROLE_RS'))
            $params['search']['agency'] = ($this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null);
        elseif ($this->get('security.authorization_checker')->isGranted('ROLE_CA') && !$this->get('security.authorization_checker')->isGranted('ROLE_RS')) {
            $params['search']['agency'] = ($this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null);
            $params['search']['activity_account_owner'] = $this->get('enigmatic_crm.manager.user')->getCurrent();
        }
        
        $activities = $this->get('enigmatic_crm.manager.activity')->getAllByDate(\DateTime::createFromFormat('Y-m-d H:i:s', $_GET['start'].'00:00:00'), \DateTime::createFromFormat('Y-m-d H:i:s', $_GET['end'].'00:00:00'), $params, true);

        $events = array();
        foreach ($activities as $activity) {
            $events[] = $this->get('enigmatic_crm.service.calendar')->ActivityToEvent($activity);
        }

        return new Response(json_encode($events), 200, array('Content-Type' => 'application/json'));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function calendarEventSaveAction (Activity $activity) {

        if (!$this->get('enigmatic_crm.service.grant')->grantActivity($activity, 'edit'))
            throw new AccessDeniedException();

        if (isset($_POST['date_start'])) {
            if ($date = \DateTime::createFromFormat('d-m-Y H:i:s', $_POST['date_start'].':00'))
                $activity->setDateStart($date);
        }
        if (isset($_POST['date_end'])) {
            if ($date = \DateTime::createFromFormat('d-m-Y H:i:s', $_POST['date_end'].':00'))
                $activity->setDateEnd($date);
        }

        if ($this->get('validator')->validate($activity)) {
            $this->get('enigmatic_crm.manager.activity')->save($activity);
            return new Response(json_encode(array(
                'success' => true
            )), 200, array('Content-Type' => 'application/json'));
        }
        else {
            return new Response(json_encode(array(
                'success' => false
            )), 200, array('Content-Type' => 'application/json'));
        }
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function viewAction(Activity $activity, $box = false)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantActivity($activity))
            throw new AccessDeniedException();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Activity:view.html.twig', array(
            'activity'       => $activity,
            'box'            => $box
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function addAction(Account $account = null, Activity $activity = null)
    {
        $replan = false;
        if ($activity)
            $replan = true;

        $activity = $this->get('enigmatic_crm.manager.activity')->create($account, $activity);

        if (isset($_POST['date_start'])) {
            if ($date = \DateTime::createFromFormat('d-m-Y H:i:s', $_POST['date_start'].':00'))
                $activity->setDateStart($date);
        }

        $form = $this->createForm('enigmatic_crm_activity', $activity);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('enigmatic_crm.manager.activity')->save($activity);

            $this->get('session')->getFlashBag()->add('success', $replan?$this->get('translator')->trans('enigmatic.crm.activity.message.replanned'):$this->get('translator')->trans('enigmatic.crm.activity.message.add'));
            if ($account)
                return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));
            else
                return $this->redirect($this->generateUrl('enigmatic_crm_activity_view', array('activity'=> $activity->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Activity:form.html.twig', array(
            'activity'      => $activity,
            'account'       => $account,
            'replan'        => $replan,
            'box'           => null,
            'form'          => $form->createView(),
        ), (($form->isSubmitted() && $form->isValid()) || !$form->isSubmitted())));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function updateAction(Activity $activity, $box = false)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantActivity($activity, 'edit') || $activity->getReplanned())
            return $this->redirect($this->generateUrl($box?'enigmatic_crm_activity_view_box':'enigmatic_crm_activity_view', array('activity'=> $activity->getId())));

        $form = $this->createForm('enigmatic_crm_activity', $activity);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.activity')->save($activity);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.activity.message.update'));
            return $this->redirect($this->generateUrl('enigmatic_crm_activity_view', array('activity'=> $activity->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Activity:form.html.twig', array(
            'activity'      => $activity,
            'account'       => null,
            'replan'        => false,
            'box'           => $box,
            'form'          => $form->createView(),
        )), (($form->isSubmitted() && $form->isValid()) || !$form->isSubmitted()));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function removeAction(Activity $activity)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantActivity($activity, 'delete'))
            throw new AccessDeniedException();

        $this->get('enigmatic_crm.manager.activity')->remove($activity);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.activity.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_activity_calendar'));
    }

}
