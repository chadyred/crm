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
