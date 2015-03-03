<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class CampaignFaxingTestType extends AbstractType
{
   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'text', array (
                'label'         => 'enigmatic.crm.campaign_faxing.form.field.test.phone.label',
                'required'      => true,
                'constraints' => array(
                    new Regex(array('pattern' => '/^([+]{1}[0-9]{1})?[0-9]{10}$/')),
                    new NotNull(),
                ),
                'attr'          => array(
                    'pattern'   => '^([+]{1}[0-9]{1})?[0-9]{10}$'
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
        return 'enigmatic_crm_campaign_faxing_test';
    }
}
