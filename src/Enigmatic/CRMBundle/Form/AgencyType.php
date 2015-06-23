<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgencyType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array (
                'label'         => 'enigmatic.crm.agency.form.field.name.label',
                'required'      => true,
            ))
            ->add('address', 'text', array (
                'label'         => 'enigmatic.crm.agency.form.field.address.label',
                'required'      => true,
            ))
            ->add('addressCpl', 'text', array (
                'label'         => 'enigmatic.crm.agency.form.field.addressCpl.label',
                'required'      => false,
            ))
            ->add('city', 'enigmatic_city', array(
                'required'      => true,
                'label'         => 'enigmatic.crm.agency.form.field.city.label',
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\CRMBundle\Entity\Agency'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_agency';
    }
}
