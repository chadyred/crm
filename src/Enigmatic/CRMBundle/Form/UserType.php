<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CRMBundle\Entity\AccountOwnerEnd;
use Enigmatic\CRMBundle\Entity\AgencyUser;
use Enigmatic\CRMBundle\Entity\AgencyUserEnd;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array(
                'label' => 'enigmatic.crm.user.form.field.firstname.label',
                'required' => true,
            ))
            ->add('name', 'text', array(
                'label' => 'enigmatic.crm.user.form.field.name.label',
                'required' => true,
            ))
            ->add('user', 'enigmatic_crm_user_security')
            ->add('newAgency', 'enigmatic_crm_agency_user');


        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($options) {
                $event->getData()->setNewAgency(new AgencyUser($event->getData(), $event->getData()->getAgency()));
            }
        );

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use($options) {
                if ($event->getData()->getNewAgency()) {
                    if ($event->getData()->getAgency() != $event->getData()->getNewAgency()->getAgency()) {
                        if ($event->getData()->getAgency()) {
                            $last_agency_user = $event->getData()->getAgencies()->first();
                            $last_agency_user->setEnd(new AgencyUserEnd($last_agency_user));
                        }
                        $event->getData()->getNewAgency()->setUser($event->getData());
                        $event->getData()->addAgency($event->getData()->getNewAgency());

                        foreach ($event->getData()->getAssignedAccount() as $user_owner) {
                            if (!$user_owner->getEnd())
                                $user_owner->setEnd(new AccountOwnerEnd($user_owner));
                        }

                    }
                }
            }
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\CRMBundle\Entity\User',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_user';
    }
}
