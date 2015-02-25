<?php

namespace Enigmatic\CRMBundle\Controller;
use Enigmatic\CRMBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\SecurityExtraBundle\Annotation\Secure;

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

        $content = $this->renderView('EnigmaticCRMBundle:User:list.html.twig', array(
            'users'         => $users,
            'params'        => $params
        ));

        return $this->get('enigmatic.render')->render($content);
    }

    /**
     * @Secure(roles={"ROLE_RS"})
     */
    public function viewAction(User $user)
    {
        $content = $this->renderView('EnigmaticCRMBundle:User:view.html.twig', array(
            'user'       => $user
        ));

        return $this->get('enigmatic.render')->render($content);
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

        $content = $this->renderView('EnigmaticCRMBundle:User:form.html.twig', array(
            'user'          => $user,
            'form'          => $form->createView(),
        ));

        return $this->get('enigmatic.render')->render($content);
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

        $content = $this->renderView('EnigmaticCRMBundle:User:form.html.twig', array(
            'user'          => $user,
            'form'          => $form->createView(),
        ));

        return $this->get('enigmatic.render')->render($content);
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

}
