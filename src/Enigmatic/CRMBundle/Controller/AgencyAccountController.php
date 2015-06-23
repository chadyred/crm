<?php

namespace Enigmatic\CRMBundle\Controller;

use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\AgencyAccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;

class AgencyAccountController extends Controller
{
    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function linkAccountAction(Account $account, $md5) {
        if ($this->get('enigmatic_crm.service.account')->checkLinkDuplicate($account, $md5)) {
            if ($agency = $this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency()) {
                $this->get('enigmatic_crm.manager.agency_account')->save($this->get('enigmatic_crm.manager.agency_account')->create($account, $agency));
                $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency_account.message.link_account'));
                if ($this->get('security.authorization_checker')->isGranted('ROLE_RCA'))
                    return $this->redirect($this->generateUrl('enigmatic_crm_account_add_first_owner', array('account'=> $account->getId())));
                elseif ($this->get('security.authorization_checker')->isGranted('ROLE_CA'))
                    $this->get('enigmatic_crm.manager.account_owner')->save($this->get('enigmatic_crm.manager.account_owner')->create($account, $this->get('enigmatic_crm.manager.user')->getCurrent()));
                return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));

            }
        }
        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency_account.message.link_error'));
        return $this->redirect($this->generateUrl('enigmatic_crm_account_add'));
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function addAction(Account $account, $first = false)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccount($account))
            throw new AccessDeniedException();

        $agency_account = $this->get('enigmatic_crm.manager.agency_account')->create($account);
        $form = $this->createForm('enigmatic_crm_agency_account', $agency_account);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.agency_account')->save($agency_account);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency_account.message.add'));
            return $this->redirect($first?$this->generateUrl('enigmatic_crm_account_owner_add_first', array('account'=> $account->getId())):$this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:AgencyAccount:form.html.twig', array(
            'agency_account'    => $agency_account,
            'first'             => $first,
            'form'              => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function updateAction(AgencyAccount $agency_account)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAgencyAccount($agency_account))
            throw new AccessDeniedException();

        $form = $this->createForm('enigmatic_crm_agency_account', $agency_account);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('enigmatic_crm.manager.agency_account')->save($agency_account);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency_account.message.update'));
            return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $agency_account->getAccount()->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:AgencyAccount:form.html.twig', array(
            'agency_account'    => $agency_account,
            'first'             => false,
            'form'              => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function removeAction(AgencyAccount $agency_account)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAgencyAccount($agency_account))
            throw new AccessDeniedException();

        $this->get('enigmatic_crm.manager.agency_account')->remove($agency_account);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency_account.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $agency_account->getAccount()->getId())));
    }
}
