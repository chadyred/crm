<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CRMBundle\Entity\CampaignMailing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignMailingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array (
                'label'             => 'enigmatic.crm.campaign_mailing.form.field.name.label',
                'required'          => true,
            ))
            ->add('emailSubject', 'text', array (
                'label'             =>'enigmatic.crm.campaign_mailing.form.field.emailSubject.label',
                'required'          => true,
            ))
            ->add('emailBody', 'ckeditor', array (
                'label'         => 'enigmatic.crm.campaign_mailing.form.field.emailBody.label',
                'required'      => false,
                'config_name'   => 'normal',
            ))
            ->add('dateSended', 'datetime', array (
                'label'         => 'enigmatic.crm.campaign_mailing.form.field.dateSended.label',
                'widget'        => 'single_text',
                'input'         => 'datetime',
                'format'        => 'dd-MM-yyyy H:m',
                'required'      => true,
                'attr'          => array(
                    'class'     => 'datetimepicker',
                    'placeholder'     => 'dd-mm-yyyy h:m',
                )
            ))
            ->add('state', 'genemu_jqueryselect2_choice', array(
                'choices'       => array(
                    CampaignMailing::CAMPAIGN_MAILING_LOCKED  => 'enigmatic.crm.campaign_mailing.form.field.state.locked.label',
                    CampaignMailing::CAMPAIGN_MAILING_WAITING => 'enigmatic.crm.campaign_mailing.form.field.state.waiting.label',
                ),
                'required'      => true,
                'multiple'      => false,
                'expanded'      => false,
                'label'         => 'enigmatic.crm.campaign_mailing.form.field.state.label',
            ))
            ->add('contacts', 'entity', array(
                'class' => 'EnigmaticCRMBundle:Contact',
                'multiple' => true,
                'expanded' => true,
                'label' => 'enigmatic.crm.campaign_mailing.form.field.contact.label',
                'required' => false
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            if (!$event->getData()->getOwner()) {
                $event->getForm()->add('owner', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:User',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'enigmatic.crm.campaign_mailing.form.field.owner.label',
                    'empty_value' => 'enigmatic.crm.campaign_mailing.form.field.owner.empty_value',
                    'required' => true
                ));
            }
        });

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) {

            }
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\CRMBundle\Entity\CampaignMailing'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_campaign_mailing';
    }
}
