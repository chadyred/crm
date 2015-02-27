<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\Email;

class CampaignMailingTestType extends AbstractType
{
   
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array (
                'label'         => 'enigmatic.crm.campaign_mailing.form.field.test.email.label',
                'required'      => true,
                'constraints' => array(
                    new Email(),
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
        return 'enigmatic_crm_campaign_mailing_test';
    }
}
