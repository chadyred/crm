<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CRMBundle\Entity\CampaignFaxing;
use Enigmatic\CRMBundle\Entity\CampaignMailing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignFaxingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array (
                'label'             => 'enigmatic.crm.campaign_faxing.form.field.name.label',
                'required'          => true,
            ))
            ->add('dateSended', 'datetime', array (
                'label'         => 'enigmatic.crm.campaign_faxing.form.field.dateSended.label',
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
                    CampaignFaxing::CAMPAIGN_FAXING_LOCKED  => 'enigmatic.crm.campaign_faxing.form.field.state.locked.label',
                    CampaignFaxing::CAMPAIGN_FAXING_WAITING => 'enigmatic.crm.campaign_faxing.form.field.state.waiting.label',
                ),
                'required'      => true,
                'multiple'      => false,
                'expanded'      => false,
                'label'         => 'enigmatic.crm.campaign_faxing.form.field.state.label',
            ))
            ->add('contacts', 'entity', array(
                'class' => 'EnigmaticCRMBundle:Contact',
                'multiple' => true,
                'expanded' => true,
                'label' => 'enigmatic.crm.campaign_faxing.form.field.contact.label',
                'required' => false
            ))
            ->add('faxs', 'collection', array(
                'type'          => 'enigmatic_crm_campaign_faxing_fax',
                'required'      => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'label'         => 'enigmatic.crm.contact.form.field.fax.label',
                'prototype'         => true,
                'prototype_name'    => '__campaign_faxing_fax__',
                'attr'              => array(
                    'class'                     => 'form_collection',
                    'data-prototype_name'       => '__campaign_faxing_fax__',
                    'data-min'                  => '0',
                    'data-max'                  => '10',
                    'data-auto_add'             => 'true',
                    'data-title'                => '',
                    'data-text_link_add'        => 'Ajouter un document',
                    'data-text_link_suppr'      => 'Supprimer ce document',
                )
            ))

        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            if (!$event->getData()->getOwner()) {
                $event->getForm()->add('owner', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:User',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'enigmatic.crm.campaign_faxing.form.field.owner.label',
                    'empty_value' => 'enigmatic.crm.campaign_faxing.form.field.owner.empty_value',
                    'required' => true
                ));
            }
        });

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) {
                if (count($event->getData()->getFaxs())) {
                    foreach ($event->getData()->getFaxs() as $fax) {
                        $fax->setCampaign($event->getData());
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
            'data_class' => 'Enigmatic\CRMBundle\Entity\CampaignFaxing'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_campaign_faxing';
    }
}
