<?php

namespace Enigmatic\OROMailingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contact', 'entity', array(
                'class'         => 'OroCRM\Bundle\ContactBundle\Entity\Contact',
                'multiple'      => false,
                'expanded'      => false,
                'label'         => 'enigmatic.oro.campaign.contact.label',
                'required'      => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\OROMailingBundle\Entity\CampaignContact'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_oro_mailingbundle_campaign_contact';
    }
}
