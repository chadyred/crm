<?php

namespace Enigmatic\OROMailingBundle\Controller;

use Enigmatic\OROMailingBundle\Entity\Campaign;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CampaignController extends Controller
{
    public function indexAction()
    {
        $campaigns = $this->get('doctrine')->getManager()->getRepository('EnigmaticOROMailingBundle:Campaign')->findAll();

        return $this->render('EnigmaticOROMailingBundle:Campaign:index.html.twig', array(
            'campaigns'         => $campaigns,
        ));
    }

    public function addAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $campaign = new Campaign($user);

        $form = $this->createForm('enigmatic_oro_mailingbundle_campaign', $campaign);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('doctrine')->getManager()->persist($campaign);
            $this->get('doctrine')->getManager()->flush();

            $this->get('session')->getFlashBag()->add('success', sprintf('La campagne %s a été ajouté', $campaign->getName()));
            return $this->redirect($this->generateUrl('enigmatic_oro_marketing_mailing_view', array('campaign' => $campaign->getId())));
        }

        return $this->render('EnigmaticOROMailingBundle:Campaign:form.html.twig', array(
            'form'          => $form->createView(),
            'campaign'      => $campaign,
        ));
    }

    public function viewAction(Campaign $campaign)
    {
        return $this->render('EnigmaticOROMailingBundle:Campaign:view.html.twig', array(
            'campaign'  => $campaign,
        ));
    }

    public function updateAction(Campaign $campaign)
    {
        $form = $this->createForm('enigmatic_oro_mailingbundle_campaign', $campaign);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('doctrine')->getManager()->flush();

            $this->get('session')->getFlashBag()->add('success', sprintf('La campagne %s a été modifié', $campaign->getName()));
            return $this->redirect($this->generateUrl('enigmatic_oro_marketing_mailing_view', array('campaign' => $campaign->getId())));
        }

        return $this->render('EnigmaticOROMailingBundle:Campaign:form.html.twig', array(
            'form'          => $form->createView(),
            'campaign'      => $campaign,
        ));
    }

    public function removeAction(Campaign $campaign)
    {
        $this->get('doctrine')->getManager()->remove($campaign);
        $this->get('doctrine')->getManager()->flush();

        $this->get('session')->getFlashBag()->add('success', sprintf('La campagne %s a été supprimée', $campaign->getName()));
        return $this->redirect($this->generateUrl('enigmatic_oro_marketing_mailing_home'));
    }


    public function searchContactAction() {

        $contact_name = $this->get('request')->request->get('contact_name');
        $account_name = $this->get('request')->request->get('account_name');
        $zipcode = $this->get('request')->request->get('zipcode');

        $query = $this->get('doctrine')->getRepository('OroCRMContactBundle:Contact')->createQueryBuilder('_contact');
        $query
            ->leftjoin('_contact.accounts', '_accounts')
            ->leftjoin('_contact.addresses', '_adresses')
            ->addSelect('_accounts')
            ->addSelect('_adresses')
            ->where('(_contact.lastName LIKE :contact_name OR _contact.firstName LIKE :contact_name)')
            ->setParameter('contact_name', '%'.$contact_name.'%')
//            ->orderBy('_contact.firstName', 'ASC')
//            ->addOrderBy('_contact.lastName', 'ASC')
            ->orderBy('_accounts.name', 'ASC')
            ->addOrderBy('_contact.lastName', 'ASC')
            ;


        if ($account_name) {
            $query = $query ->andWhere('_accounts.name LIKE :account_name')
                            ->setParameter('account_name', '%'.$account_name.'%');
        }
        if ($zipcode) {
            $query = $query ->andWhere('_adresses.postalCode LIKE :zipcode')
                            ->setParameter('zipcode', '%'.$zipcode.'%');
        }

        $query = $query->getQuery();

        $contacts = $query->getResult();
        $tab_result = array();

        foreach ($contacts as $contact) {

            $name = '';
            foreach ($contact->getAccounts() as $account) {
                $name .= $account->getName().' ';
            }

            $name .= ' ( '.$contact->getLastName().' '.$contact->getFirstName().' )';

            $tab_result[] = array (
                'id'    => $contact->getId(),
                'name'  => $name
            );
        }
        return new Response(json_encode(array(
            'success'  => true,
            'result'   => $tab_result,
        )), 200, array('Content-Type' => 'application/json'));
    }
}
