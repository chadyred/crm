<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\File;

class AccountImportType extends AbstractType
{
   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'required'      => true,
                'label'         => 'enigmatic.crm.account_import.form.field.file.label',
                'constraints' => array(
                    new File(array(
                        'maxSize' => '8M',
                        'mimeTypesMessage' => 'enigmatic.crm.account_import.file.mime_type',
                        'mimeTypes' => array(
                            'text/plain',
                        ))
                    ),
                )
            ))
            ->add('agency', 'genemu_jqueryselect2_entity', array(
                'class' => 'EnigmaticCRMBundle:Agency',
                'multiple' => true,
                'expanded' => false,
                'label' => 'enigmatic.crm.agency_account.form.field.agency.label',
                'required' => true
            ))
            ->add('owner', 'genemu_jqueryselect2_entity', array(
                'class' => 'EnigmaticCRMBundle:User',
                'property' => 'userWithAgencyName',
                'multiple' => true,
                'expanded' => false,
                'label' => 'enigmatic.crm.account_owner.form.field.user.label',
                'required' => true
            ))
            ->add('sync_societe_com', 'choice', array(
                'choices'       => array(
                    true   =>   'enigmatic.crm.account_import.form.field.sync_societe_com.label',
                ),
                'required'      => false,
                'multiple'      => true,
                'expanded'      => true,
                'label'         => null,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'            => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_account_import';
    }
}
