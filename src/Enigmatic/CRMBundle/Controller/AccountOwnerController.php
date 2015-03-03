<?php

namespace Enigmatic\CRMBundle\Controller;

use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\AccountOwner;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use JMS\SecurityExtraBundle\Annotation\Secure;

class AccountOwnerController extends Controller
{
    /**
     * @Secure(roles={"ROLE_RCA"})
     */
    public function addAction(Account $account, $first = false)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccount($account))
            throw new AccessDeniedException();

        $account_owner = $this->get('enigmatic_crm.manager.account_owner')->create($account);
        $form = $this->createForm('enigmatic_crm_account_owner', $account_owner);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.account_owner')->save($account_owner);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.account_owner.message.add'));
            return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:AccountOwner:form.html.twig', array(
            'account_owner'     => $account_owner,
            'first'             => $first,
            'form'              => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_RCA"})
     */
    public function removeAction(AccountOwner $account_owner)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccountOwner($account_owner))
            throw new AccessDeniedException();

        $this->get('enigmatic_crm.manager.account_owner')->end($account_owner);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.account_owner.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $account_owner->getAccount()->getId())));
    }
}
