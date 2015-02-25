<?php

namespace Enigmatic\CRMBundle\Controller;
use Enigmatic\CRMBundle\Entity\Agency;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

class AgencyController extends Controller
{
    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function listAction()
    {
        $params = $this->get('enigmatic_crm.service.list')->parseRequest($this->get('request')->request->all());
        $agencies = $this->get('enigmatic_crm.manager.agency')->getList($params['page'], $params['limit'], $params);
        $params['entity'] = 'Agency';
        $params['total'] = $agencies->count();

        $content = $this->renderView('EnigmaticCRMBundle:Agency:list.html.twig', array(
            'agencies'      => $agencies,
            'params'        => $params
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function viewAction(Agency $agency)
    {
        $content = $this->renderView('EnigmaticCRMBundle:Agency:view.html.twig', array(
            'agency'       => $agency,
            'map'          => $this->get('enigmatic_crm.service.map')->generateAction($agency->getAddress().', '.$agency->getCity()->getName().' '.$agency->getCity()->getCanonicalZipcode(), $agency->getName(), '400px', '400px;')
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function addAction()
    {
        $agency = $this->get('enigmatic_crm.manager.agency')->create();
        $form = $this->createForm('enigmatic_crm_agency', $agency);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.agency')->save($agency);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency.message.add'));
            return $this->redirect($this->generateUrl('enigmatic_crm_agency_view', array('agency'=> $agency->getId())));
        }

        $content = $this->renderView('EnigmaticCRMBundle:Agency:form.html.twig', array(
            'agency'        => $agency,
            'form'          => $form->createView(),
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function updateAction(Agency $agency)
    {
        $form = $this->createForm('enigmatic_crm_agency', $agency);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.agency')->save($agency);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency.message.update'));
            return $this->redirect($this->generateUrl('enigmatic_crm_agency_view', array('agency'=> $agency->getId())));
        }

        $content = $this->renderView('EnigmaticCRMBundle:Agency:form.html.twig', array(
            'agency'        => $agency,
            'form'          => $form->createView(),
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function removeAction(Agency $agency)
    {
        $this->get('enigmatic_crm.manager.agency')->remove($agency);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.agency.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_agency_list'));
    }

}
