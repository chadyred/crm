<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class AccountType extends AbstractType
{
    protected $authorizationChecker;

    /**
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(AuthorizationChecker $authorizationChecker) {
        $this->authorizationChecker  = $authorizationChecker;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array (
                'label'         => 'enigmatic.crm.account.form.field.name.label',
                'required'      => true,
            ))
            ->add('siret', 'text', array (
                'label'         => 'enigmatic.crm.account.form.field.siret.label',
                'required'      => false,
                'attr' => array(
                    'pattern' => '^([0-9]{14})$'
                )
            ))
            ->add('address', 'text', array (
                'label'         => 'enigmatic.crm.account.form.field.address.label',
                'required'      => false,
            ))
            ->add('addressCpl', 'text', array (
                'label'         => 'enigmatic.crm.account.form.field.addressCpl.label',
                'required'      => false,
            ))
            ->add('phone', 'text', array (
                'label'         => 'enigmatic.crm.account.form.field.phone.label',
                'required'      => false,
                'attr' => array(
                    'pattern' => '^([+]{1}[0-9]{1})?[0-9]{10}$'
                )
            ))
            ->add('fax', 'text', array (
                'label'         => 'enigmatic.crm.account.form.field.fax.label',
                'required'      => false,
                'attr' => array(
                    'pattern' => '^([+]{1}[0-9]{1})?[0-9]{10}$'
                )
            ))
            ->add('activity', 'text', array (
                'label'         => 'enigmatic.crm.account.form.field.activity.label',
                'required'      => false,
            ))
            ->add('city', 'enigmatic_city', array(
                'required'      => false,
                'label'         => 'enigmatic.crm.account.form.field.city.label',
            ))
        ;

//        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
//            $builder->add('agencies', 'collection', array(
//                'type'          => 'enigmatic_crm_agency_account',
//                'required'      => false,
//                'allow_add'     => true,
//                'allow_delete'  => true,
//                'label'         => 'enigmatic.crm.account.form.field.agencies.label',
//                'prototype'         => true,
//                'prototype_name'    => '__agencies__',
//                'attr'              => array(
//                    'class'                     => 'form_collection',
//                    'data-prototype_name'       => '__agencies__',
//                    'data-min'                  => '0',
//                    'data-max'                  => '0',
//                    'data-auto_add'             => 'true',
//                    'data-title'                => '',
//                    'data-text_link_add'        => 'Lier à une agence',
//                    'data-text_link_suppr'      => 'Supprimer cette liaison',
//                )
//            ));
//        }

//        $builder->addEventListener(
//            FormEvents::SUBMIT,
//            function (FormEvent $event) use($options) {
//                if (count($event->getData()->getAgencies()))
//                    foreach($event->getData()->getAgencies() as $agency_account) {
//                        $agency_account->setAccount($event->getData());
//                    }
//            }
//        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'            => 'Enigmatic\CRMBundle\Entity\Account',
            'cascade_validation'    => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_account';
    }
}
