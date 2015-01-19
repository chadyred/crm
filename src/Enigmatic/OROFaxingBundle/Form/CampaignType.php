<?php

namespace Enigmatic\OROFaxingBundle\Form;

use Enigmatic\OROFaxingBundle\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array (
                'label'             => 'enigmatic.oro.faxing.campaign.name.label',
                'required'          => true,
            ))
            ->add('dateSended', 'datetime', array (
                'label'         => 'enigmatic.oro.faxing.campaign.date_sended.label',
                'required'      => true,
            ))
            ->add('state', 'choice', array(
                'choices'       => array(
                    Campaign::CAMPAIGN_FAXING_LOCKED => 'enigmatic.oro.faxing.campaign.state.locked.label',
                    Campaign::CAMPAIGN_FAXING_WAITING => 'enigmatic.oro.faxing.campaign.state.waiting.label'
                ),
                'required'      => true,
                'multiple'      => false,
                'expanded'      => false,
                'label'         => 'enigmatic.oro.faxing.campaign.state.label'
            ))
            ->add('fax', 'collection', array(
                'type'          => 'enigmatic_oro_faxingbundle_campaign_fax',
                'allow_add'     => true,
                'allow_delete'  => true,
                'label'         => false,
                'prototype'         => true,
                'prototype_name'    => '__fax__',
                'attr'              => array(
                    'class'                     => 'form_collection',
                    'data-prototype_name'       => '__fax__',
                    'data-min'                  => 1,
                    'data-max'                  => 10,
                    'data-auto_add'             => 'true',
                    'data-title'                => '',
                    'data-text_link_add'        => 'Ajouter un autre fax',
                    'data-text_link_suppr'      => 'Supprimer ce fax',
                )
            ))
            ->add('contacts', 'collection', array(
                'type'              => 'enigmatic_oro_faxingbundle_campaign_contact',
                'allow_add'         => true,
                'allow_delete'      => true,
                'label'             => false,
                'prototype'         => true,
                'prototype_name'    => '__contact__',
            ))
        ;

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) {
                if ($event->getData()->getContacts()) {
                    foreach ($event->getData()->getContacts() as $item) {
                        $item->setCampaign($event->getData());
                    }
                }
                if ($event->getData()->getFax()) {
                    foreach ($event->getData()->getFax() as $item) {
                        $item->setCampaign($event->getData());
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
            'data_class' => 'Enigmatic\OROFaxingBundle\Entity\Campaign',
            'cascade_validation'    => true,
            'file_required'         => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_oro_faxingbundle_campaign';
    }
}
