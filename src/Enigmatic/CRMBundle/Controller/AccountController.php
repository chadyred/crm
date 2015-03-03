<?php

namespace Enigmatic\CRMBundle\Controller;
use Ddeboer\DataImport\Reader\CsvReader;
use Enigmatic\CRMBundle\Entity\Account;
use Enigmatic\CRMBundle\Entity\AgencyAccount;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AccountController extends Controller
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

        $accounts = $this->get('enigmatic_crm.manager.account')->getList($params['page'], $params['limit'], $params);
        $params['entity'] = 'Account';
        $params['total'] = $accounts->count();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Account:list.html.twig', array(
            'accounts'      => $accounts,
            'params'        => $params
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function viewAction(Account $account)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccount($account))
            throw new AccessDeniedException();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Account:view.html.twig', array(
            'account'   => $account,
            'map'       => $this->get('enigmatic_crm.service.map')->generateAction($account->getAddress().', '.($account->getCity()?$account->getCity()->getName():'').' '.($account->getCity()?$account->getCity()->getCanonicalZipcode():''), null, '400px', '400px;')
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function addAction()
    {
        $account = $this->get('enigmatic_crm.manager.account')->create();
        $form = $this->createForm('enigmatic_crm_account', $account);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.account')->save($account);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.account.message.add'));
            return $this->redirect(count($account->getOwners())?$this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())):(count($account->getAgencies())?$this->generateUrl('enigmatic_crm_account_add_first_owner', array('account'=> $account->getId())):$this->generateUrl('enigmatic_crm_account_add_first_agency', array('account'=> $account->getId()))));
        }
        elseif ($form->isSubmitted())
            $link_duplicate = $this->get('enigmatic_crm.service.account')->generateLinkDuplicate($form);

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Account:form.html.twig', array(
            'link_duplicate'    => isset($link_duplicate)?$link_duplicate:false,
            'account'           => $account,
            'form'              => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_RCA"})
     */
    public function updateAction(Account $account)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccount($account))
            throw new AccessDeniedException();

        $form = $this->createForm('enigmatic_crm_account', $account);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.account')->save($account);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.account.message.update'));
            return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Account:form.html.twig', array(
            'account'       => $account,
            'form'          => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function removeAction(Account $account)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccount($account))
            throw new AccessDeniedException();

        $this->get('enigmatic_crm.manager.account')->remove($account);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.account.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_account_list'));
    }





    /**
     * @Secure(roles={"ROLE_RCA"})
     */
    public function importAction()
    {
        $form = $this->createForm('enigmatic_crm_account_import');

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {

            $account_manager = $this->get('enigmatic_crm.manager.account');

            $data = $form->getData();
            $file = new \SplFileObject($data['file']);
            $reader = new CsvReader($file, ';');
            $reader->setHeaderRowNumber(0);
            foreach ($reader as $row) {
                $row = array_map(function($str){return iconv("Windows-1252", "UTF-8", $str);}, $row);

                $account = $account_manager->create();
                $account->setName($row['Nom']);
                $account->setSiret($row['Siret']);
                $account->setAddress($row['Adresse']);
                $account->setAddressCpl($row['Adresse Cpl']);
                $account->setPhone($row['Telephone']);

                if ($this->get('validator')->validate($account))
                    $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('ok'));

//                    $account_manager->save($account);
                else
                    $this->get('session')->getFlashBag()->add('error', $this->get('translator')->trans('erreur'));
            }


//            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.account.message.update'));
//            return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:Account:import.html.twig', array(
            'form'          => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function linkAccountToAgencyAction(Account $account, $md5) {
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
    public function addAgencyAction(Account $account, $first = false)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccount($account))
            throw new AccessDeniedException();

        $agency_account = $this->get('enigmatic_crm.manager.agency_account')->create($account);
        $form = $this->createForm('enigmatic_crm_agency_account', $agency_account);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.agency_account')->save($agency_account);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency_account.message.add'));
            return $this->redirect($first?$this->generateUrl('enigmatic_crm_account_add_first_owner', array('account'=> $account->getId())):$this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:AgencyAccount:form.html.twig', array(
            'agency_account'    => $agency_account,
            'first'             => $first,
            'form'              => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_RCA"})
     */
    public function addOwnerAction(Account $account, $first = false)
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

}
