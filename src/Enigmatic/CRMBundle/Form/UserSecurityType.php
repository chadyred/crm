<?php

namespace Enigmatic\CRMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserSecurityType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array (
                'label'     => 'user.form.field.email.label',
                'required'  => true,
            ))
            ->add('newRole', 'choice', array(
                'choices'       => array(
                    'ROLE_CA'   =>  'enigmatic.crm.user.security.form.field.roles.ca.label',
                    'ROLE_RCA'  =>  'enigmatic.crm.user.security.form.field.roles.rca.label',
                    'ROLE_RS'   =>  'enigmatic.crm.user.security.form.field.roles.rs.label',
                ),
                'required'      => true,
                'multiple'      => false,
                'expanded'      => true,
                'label'         => 'enigmatic.crm.user.security.form.field.roles.label',
            ))
            ->add('locked', 'choice', array(
                'choices'       => array(
                    true   =>  'enigmatic.crm.user.security.form.field.locked.lock.label',
                    false  =>  'enigmatic.crm.user.security.form.field.locked.unlock.label',
                ),
                'required'      => true,
                'multiple'      => false,
                'expanded'      => true,
                'label'         => 'enigmatic.crm.user.security.form.field.locked.label',
            ))
        ;

        if ($options['password']) {
            $builder
                ->add('plainPassword', 'repeated', array(
                    'type'              => 'password',
                    'first_options'     => array('label' => 'user.form.field.password.label'),
                    'second_options'    => array('label' => 'user.form.field.password.confirm.label'),
                    'invalid_message'   => 'fos_user.password.mismatch',
                    'required'          => false
                ))
            ;
        }

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($options) {
                if ($event->getData()) {
                    if ($event->getData()->hasRole('ROLE_RS'))
                        $event->getData()->setNewRole('ROLE_RS');
                    elseif ($event->getData()->hasRole('ROLE_RCA'))
                        $event->getData()->setNewRole('ROLE_RCA');
                    else {
                        $event->getData()->setNewRole('ROLE_CA');
                    }
                }
            }
        );
        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use($options) {
                $event->getData()->addRole($event->getData()->getNewRole());
            }
        );

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'    => 'UserBundle\Entity\User',
            'password'      => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_user_security';
    }
}
