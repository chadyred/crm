<?php

namespace Enigmatic\CRMBundle\Controller;

use Enigmatic\CRMBundle\Entity\CampaignMailing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CampaignMailingController extends Controller
{
    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function listAction()
    {
        $params = $this->get('enigmatic_crm.service.list')->parseRequest($this->get('request')->request->all());

        // @rp_todo : grants

        $campaigns = $this->get('enigmatic_crm.manager.campaign_mailing')->getList($params['page'], $params['limit'], $params);
        $params['entity'] = 'CampaignMailing';
        $params['total'] = $campaigns->count();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:CampaignMailing:list.html.twig', array(
            'campaigns'     => $campaigns,
            'params'        => $params
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function viewAction(CampaignMailing $campaign)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantCampaignMailing($campaign))
            throw new AccessDeniedException();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:CampaignMailing:view.html.twig', array(
            'campaign'       => $campaign
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function addAction()
    {
        $campaign = $this->get('enigmatic_crm.manager.campaign_mailing')->create($this->get('enigmatic_crm.manager.user')->getCurrent());
        $form = $this->createForm('enigmatic_crm_campaign_mailing', $campaign);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.campaign_mailing')->save($campaign);
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.campaign_mailing.message.add'));
            return $this->redirect($this->generateUrl('enigmatic_crm_campaign_mailing_view', array('campaign'=> $campaign->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:CampaignMailing:form.html.twig', array(
            'campaign'   => $campaign,
            'form'       => $form->createView()
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function updateAction(CampaignMailing $campaign)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantCampaignMailing($campaign))
            throw new AccessDeniedException();
        if ($campaign->getState() == CampaignMailing::CAMPAIGN_MAILING_SENDED)
            return $this->redirect($this->generateUrl('enigmatic_crm_campaign_mailing_list'));

        $form = $this->createForm('enigmatic_crm_campaign_mailing', $campaign);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.campaign_mailing')->save($campaign);
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.campaign_mailing.message.update'));
            return $this->redirect($this->generateUrl('enigmatic_crm_campaign_mailing_view', array('campaign'=> $campaign->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:CampaignMailing:form.html.twig', array(
            'campaign'   => $campaign,
            'form'       => $form->createView()
        )));
    }

    /**
     * @Secure(roles={"RCA"})
     */
    public function removeAction(CampaignMailing $campaign)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantCampaignMailing($campaign))
            throw new AccessDeniedException();

        $this->get('enigmatic_crm.manager.campaign_mailing')->remove($campaign);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.campaign_mailing.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_campaign_mailing_list'));
    }
}
