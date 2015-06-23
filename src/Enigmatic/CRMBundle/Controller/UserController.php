<?php

namespace Enigmatic\CRMBundle\Controller;
use Enigmatic\CRMBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function listAction()
    {
        $params = $this->get('enigmatic_crm.service.list')->parseRequest($this->get('request')->request->all());
        $users = $this->get('enigmatic_crm.manager.user')->getList($params['page'], $params['limit'], $params);
        $params['entity'] = 'User';
        $params['total'] = $users->count();

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:User:list.html.twig', array(
            'users'         => $users,
            'params'        => $params
        )));
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function viewAction(User $user)
    {
        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:User:view.html.twig', array(
            'user'       => $user
        )));
    }


    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function addAction()
    {
        $user = $this->get('enigmatic_crm.manager.user')->create();
        $form = $this->createForm('enigmatic_crm_user', $user);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.user')->save($user);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.user.message.add'));
            return $this->redirect($this->generateUrl('enigmatic_crm_user_view', array('user'=> $user->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:User:form.html.twig', array(
            'user'          => $user,
            'form'          => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function updateAction(User $user)
    {
        $form = $this->createForm('enigmatic_crm_user', $user);

        $form->handleRequest($this->get('request'));
        if ($form->isSubmitted() && $form->isValid()) {
            $this->get('enigmatic_crm.manager.user')->save($user);

            $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.user.message.update'));
            return $this->redirect($this->generateUrl('enigmatic_crm_user_view', array('user'=> $user->getId())));
        }

        return $this->get('enigmatic.render')->render($this->renderView('EnigmaticCRMBundle:User:form.html.twig', array(
            'user'          => $user,
            'form'          => $form->createView(),
        )));
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function removeAction(User $user)
    {
        $this->get('enigmatic_crm.manager.user')->remove($user);

        $this->get('session')->getFlashBag()->add('success', $this->get('translator')->trans('enigmatic.crm.user.message.remove'));
        return $this->redirect($this->generateUrl('enigmatic_crm_user_list'));
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function searchAction() {

        $params['search']['agencies'] = $this->get('request')->request->get('agencies');

        $users = $this->get('enigmatic_crm.manager.user')->getList(0, null, $params);

        $tab_result = array();
        foreach ($users as $user) {
            $tab_result[] = array (
                'id'    => $user->getId(),
                'firstname'  => $user->getFirstName(),
                'name'  => $user->getName(),
                'agency'  => $user->getAgency()->getName(),
            );
        }
        return new Response(json_encode(array(
            'success'  => true,
            'result'   => $tab_result,
        )), 200, array('Content-Type' => 'application/json'));
    }

}
