<?php

namespace Enigmatic\CRMBundle\Controller;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
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
        elseif ($this->get('security.authorization_checker')->isGranted('ROLE_CA') && !$this->get('security.authorization_checker')->isGranted('ROLE_RS')) {
            $params['search']['agency'] = ($this->get('enigmatic_crm.manager.user')->getCurrent()?$this->get('enigmatic_crm.manager.user')->getCurrent()->getAgency():null);
            $params['search']['account_owner'] = $this->get('enigmatic_crm.manager.user')->getCurrent();
        }

        $contacts = $this->get('enigmatic_crm.manager.contact')->getList($params['page'], $params['limit'], $params);
        $params['entity'] = 'Contact';
        $params['total'] = $contacts->count();

        return $this->get('enigmatic.render')->render( $this->renderView('EnigmaticCRMBundle:Contact:list.html.twig', array(
            'contacts'      => $contacts,
            'params'        => $params
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function viewAction(Contact $contact)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantContact($contact))
            throw new AccessDeniedException();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Contact:view.html.twig', array(
            'contact'   => $contact,
            'map'       => $this->get('enigmatic_crm.service.map')->generateAction(($contact->getAddress()?$contact->getAddress():'centre').', '.($contact->getCity()?$contact->getCity()->getName():'').' '.($contact->getCity()?$contact->getCity()->getCanonicalZipcode():''), null, '400px', '400px;')
        )));
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

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Contact:form.html.twig', array(
            'account'       => $account,
            'contact'       => $contact,
            'form'          => $form->createView(),
        )));
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

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Contact:form.html.twig', array(
            'account'       => null,
            'contact'       => $contact,
            'form'          => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_RCA"})
     */
    public function removeAction(Contact $contact)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantContact($contact))
            throw new AccessDeniedException();

        $this->get('enigmatic_crm.manager.contact')->remove($contact);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.contact.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_contact_list'));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function searchAction() {

        $params['search']['name'] = $this->get('request')->request->get('contact_name');
        $params['search']['account_name'] = $this->get('request')->request->get('account_name');
        $params['search']['city'] = $this->get('request')->request->get('city');
        $params['search']['hasFax'] = $this->get('request')->request->get('hasFax');
        $params['search']['hasEmail'] = $this->get('request')->request->get('hasEmail');

        $contacts = $this->get('enigmatic_crm.manager.contact')->getList(0, null, $params);

        $tab_result = array();
        foreach ($contacts as $contact) {
            $tab_result[] = array (
                'id'    => $contact->getId(),
                'account'  => $contact->getAccount()->getName(),
                'firstname'  => $contact->getFirstName()?$contact->getFirstName():'',
                'name'  => $contact->getName(),
                'fax'  => $this->get('enigmatic.phone_format')->phoneFormat($contact->getFax())
            );
        }
        return new Response(json_encode(array(
            'success'  => true,
            'result'   => $tab_result,
        )), 200, array('Content-Type' => 'application/json'));
    }

}
