<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CRMBundle\Entity\ContactPhone;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactPhoneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', 'genemu_jqueryselect2_choice', array(
                'choices'       => array(
                    ContactPhone::HOME      =>  'enigmatic.crm.contact.form.field.phones.type.home.label',
                    ContactPhone::MOBILE    =>  'enigmatic.crm.contact.form.field.phones.type.mobile.label',
                    ContactPhone::WORK      =>  'enigmatic.crm.contact.form.field.phones.type.work.label',
                    ContactPhone::FAX       =>  'enigmatic.crm.contact.form.field.phones.type.fax.label',
                    ContactPhone::OTHER     =>  'enigmatic.crm.contact.form.field.phones.type.other.label',
                ),
                'required'      => true,
                'multiple'      => false,
                'expanded'      => false,
                'label'         => null,
            ))
            ->add('phone', 'text', array (
                'label'         => null,
                'required'      => false,
                'attr' => array(
                    'pattern' => '^([+]{1}[0-9]{1})?[0-9]{10}$',
                    'placeholder'   => 'enigmatic.crm.contact.form.field.phones.phone.label',
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\CRMBundle\Entity\ContactPhone'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_contact_phone';
    }
}
