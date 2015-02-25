<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CRMBundle\Entity\AgencyUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgencyUserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('agency', 'genemu_jqueryselect2_entity', array(
                'class' => 'EnigmaticCRMBundle:Agency',
                'multiple' => false,
                'expanded' => false,
                'label' => 'enigmatic.crm.activity_user.form.field.agency.label',
                'empty_value' => 'enigmatic.crm.activity_user.form.field.agency.empty_value',
                'required' => true
            ));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\CRMBundle\Entity\AgencyUser'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_agency_user';
    }
}
