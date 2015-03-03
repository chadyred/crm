<?php

namespace Enigmatic\CRMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgencyAccountTurnoverType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            if ($event->getData() && $event->getData()->getYear() < date('Y')-1) {
                    $event->getForm()
                        ->add('year', 'hidden', array(
                            'attr'          => array(
                                'class'   => 'turnover_year'
                            )
                        ))
                        ->add('turnover', 'hidden')
                    ;
            }
            else {
                $event->getForm()
                    ->add('year', 'number', array (
                        'required'      => true,
                        'attr'          => array(
                            'class'   => 'turnover_year'
                        )
                    ))
                    ->add('turnover', 'text', array (
                        'label'         => 'CA',
                        'required'      => true,
                        'attr'          => array(
                            'placeholder'   => 'enigmatic.crm.agency_account.form.field.turnovers.turnover.placeholder',
                            'class'         => 'turnover'
                        )
                    ))
                ;
            }
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\CRMBundle\Entity\AgencyAccountTurnover'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_agency_account_turnover';
    }
}
