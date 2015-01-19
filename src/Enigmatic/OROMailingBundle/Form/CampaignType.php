<?php

namespace Enigmatic\OROMailingBundle\Form;

use Enigmatic\OROMailingBundle\Entity\Campaign;
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
                'label'             => 'enigmatic.oro.campaign.name.label',
                'required'          => true,
            ))
            ->add('emailSubject', 'text', array (
                'label'             => 'enigmatic.oro.campaign.email_subject.label',
                'required'          => true,
            ))
            ->add('emailBody', 'ckeditor', array (
                'label'         => 'enigmatic.oro.campaign.email_body.label',
                'required'      => false,
                'config_name'   => 'normal',
            ))
            ->add('dateSended', 'datetime', array (
                'label'         => 'enigmatic.oro.campaign.date_sended.label',
                'required'      => true,
            ))
            ->add('state', 'choice', array(
                'choices'       => array(
                    Campaign::CAMPAIGN_MAILING_LOCKED => 'enigmatic.oro.campaign.state.locked.label',
                    Campaign::CAMPAIGN_MAILING_WAITING => 'enigmatic.oro.campaign.state.waiting.label'
                ),
                'required'      => true,
                'multiple'      => false,
                'expanded'      => false,
                'label'         => 'enigmatic.oro.campaign.state.label'
            ))
            ->add('contacts', 'collection', array(
                'type'              => 'enigmatic_oro_mailingbundle_campaign_contact',
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
            }
        );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\OROMailingBundle\Entity\Campaign',
            'cascade_validation'    => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_oro_mailingbundle_campaign';
    }
}
