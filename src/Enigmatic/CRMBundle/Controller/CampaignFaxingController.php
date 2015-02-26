<?php

namespace Enigmatic\CRMBundle\Controller;

use Enigmatic\CRMBundle\Entity\CampaignFaxing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CampaignFaxingController extends Controller
{
    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function listAction()
    {
        if (!$this->container->getParameter('enigmatic_crm.ecofax.login') || !$this->container->getParameter('enigmatic_crm.ecofax.password'))
            $this->get('session')->getFlashBag()->add('warning', $this->get('translator')->trans('enigmatic.crm.campaign_faxing.errors.config_ecofax'));

        $params = $this->get('enigmatic_crm.service.list')->parseRequest($this->get('request')->request->all());

        // @rp_todo : grants

        $campaigns = $this->get('enigmatic_crm.manager.campaign_faxing')->getList($params['page'], $params['limit'], $params);
        $params['entity'] = 'CampaignFaxing';
        $params['total'] = $campaigns->count();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:CampaignFaxing:list.html.twig', array(
            'campaigns'     => $campaigns,
            'params'        => $params
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function viewAction(CampaignFaxing $campaign)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantCampaignFaxing($campaign))
            throw new AccessDeniedException();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:CampaignFaxing:view.html.twig', array(
            'campaign'       => $campaign
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function addAction()
    {
        $campaign = $this->get('enigmatic_crm.manager.campaign_faxing')->create($this->get('enigmatic_crm.manager.user')->getCurrent());
        $form = $this->createForm('enigmatic_crm_campaign_faxing', $campaign);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.campaign_faxing')->save($campaign);
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.campaign_faxing.message.add'));
            return $this->redirect($this->generateUrl('enigmatic_crm_campaign_faxing_view', array('campaign'=> $campaign->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:CampaignFaxing:form.html.twig', array(
            'campaign'   => $campaign,
            'form'       => $form->createView()
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function updateAction(CampaignFaxing $campaign)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantCampaignFaxing($campaign))
            throw new AccessDeniedException();
        if ($campaign->getState() == CampaignFaxing::CAMPAIGN_FAXING_SENDED)
            return $this->redirect($this->generateUrl('enigmatic_crm_campaign_faxing_list'));

        $form = $this->createForm('enigmatic_crm_campaign_faxing', $campaign);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.campaign_faxing')->save($campaign);
            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.campaign_faxing.message.update'));
            return $this->redirect($this->generateUrl('enigmatic_crm_campaign_faxing_view', array('campaign'=> $campaign->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:CampaignFaxing:form.html.twig', array(
            'campaign'   => $campaign,
            'form'       => $form->createView()
        )));
    }

    /**
     * @Secure(roles={"RCA"})
     */
    public function removeAction(CampaignFaxing $campaign)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantCampaignFaxing($campaign))
            throw new AccessDeniedException();

        $this->get('enigmatic_crm.manager.campaign_faxing')->remove($campaign);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.campaign_faxing.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_campaign_faxing_list'));
    }
}
