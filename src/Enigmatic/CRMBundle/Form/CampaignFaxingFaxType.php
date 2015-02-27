<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CRMBundle\Entity\CampaignFaxing;
use Enigmatic\CRMBundle\Entity\CampaignMailing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CampaignFaxingFaxType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $event->getForm()
                ->add('file', 'file', array (
                    'label'     => 'Fichier (pdf)',
                    'required'  => ($event->getData()?($event->getData()->getPath()?false:true):true),
                ));
        });

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use($options) {
                if ($event->getData())
                    if ($event->getData()->getFile()) {
                        $event->getData()->setDateUpdated(new \DateTime());
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
            'data_class' => 'Enigmatic\CRMBundle\Entity\CampaignFaxingFax'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_campaign_faxing_fax';
    }
}
