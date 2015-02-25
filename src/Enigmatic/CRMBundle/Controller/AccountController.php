<?php

namespace Enigmatic\CRMBundle\Controller;
use Ddeboer\DataImport\Reader\CsvReader;
use Enigmatic\CRMBundle\Entity\Account;
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

        $content = $this->renderView('EnigmaticCRMBundle:Account:list.html.twig', array(
            'accounts'      => $accounts,
            'params'        => $params
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_CA"})
     */
    public function viewAction(Account $account)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccount($account))
            throw new AccessDeniedException();

        $content = $this->renderView('EnigmaticCRMBundle:Account:view.html.twig', array(
            'account'       => $account
        ));

        return $this->get('enigmatic.render')->render($content);
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
            return $this->redirect($this->generateUrl('enigmatic_crm_account_view', array('account'=> $account->getId())));
        }

        $content = $this->renderView('EnigmaticCRMBundle:Account:form.html.twig', array(
            'account'       => $account,
            'form'          => $form->createView(),
        ));

        return $this->get('enigmatic.render')->render($content);
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

        $content = $this->renderView('EnigmaticCRMBundle:Account:form.html.twig', array(
            'account'       => $account,
            'form'          => $form->createView(),
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function removeAction(Account $account)
    {
        if (!$this->get('enigmatic_crm.service.grant')->grantAccount($account))
            throw new AccessDeniedException();

        $account->setState(Account::ARCHIVED);
        $this->get('enigmatic_crm.manager.account')->save($account);

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

        $content = $this->renderView('EnigmaticCRMBundle:Account:import.html.twig', array(
            'form'          => $form->createView(),
        ));
        return $this->get('enigmatic.render')->render($content);
    }

}
