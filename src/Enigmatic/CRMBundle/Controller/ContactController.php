<?php

namespace Enigmatic\CRMBundle\Controller;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ContactController extends Controller
{
    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function listAction()
    {
        $params = $this->get('enigmatic_crm.service.list')->parseRequest($this->get('request')->request->all());

        if ($this->get('security.authorization_checker')->isGranted('ROLE_RCA') && !$this->get('security.authorization_checker')->isGranted('ROLE_RS'))
            $params['search']['agency'] = ($this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null);
        elseif ($this->get('security.authorization_checker')->isGranted('ROLE_CA')) {
            $params['search']['agency'] = ($this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null);
            $params['search']['account_owner'] = $this->get('enigmatic_crm.manager.user')->getCurrent();
        }

        $contacts = $this->get('enigmatic_crm.manager.contact')->getList($params['page'], $params['limit'], $params);
        $params['entity'] = 'Contact';
        $params['total'] = $contacts->count();

        $content = $this->renderView('EnigmaticCRMBundle:Contact:list.html.twig', array(
            'contacts'      => $contacts,
            'params'        => $params
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function viewAction(Contact $contact)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantContact($contact))
            throw new AccessDeniedException();

        $content = $this->renderView('EnigmaticCRMBundle:Contact:view.html.twig', array(
            'contact'       => $contact
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function addAction(Account $account = null)
    {
        $contact = $this->get('enigmatic_crm.manager.contact')->create($account);
        $form = $this->createForm('enigmatic_crm_contact', $contact);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.contact')->save($contact);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.contact.message.add'));
            if ($account)
                return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));
            else
                return $this->redirect($this->generateUrl('enigmatic_crm_contact_view', array('contact'=> $contact->getId())));
        }

        $content = $this->renderView('EnigmaticCRMBundle:Contact:form.html.twig', array(
            'contact'       => $contact,
            'form'          => $form->createView(),
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function updateAction(Contact $contact)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantContact($contact))
            throw new AccessDeniedException();

        $form = $this->createForm('enigmatic_crm_contact', $contact);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.contact')->save($contact);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.contact.message.update'));
            return $this->redirect($this->generateUrl('enigmatic_crm_contact_view', array('contact'=> $contact->getId())));
        }

        $content = $this->renderView('EnigmaticCRMBundle:Contact:form.html.twig', array(
            'contact'       => $contact,
            'form'          => $form->createView(),
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"RCA"})
     */
    public function removeAction(Contact $contact)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantContact($contact))
            throw new AccessDeniedException();

        $this->get('enigmatic_crm.manager.contact')->remove($contact);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.contact.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_contact_list'));
    }

}
