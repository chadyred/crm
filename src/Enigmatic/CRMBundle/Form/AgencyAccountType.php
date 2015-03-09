<?php

namespace Enigmatic\CRMBundle\Form;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Enigmatic\CRMBundle\Entity\AgencyAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AgencyAccountType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            if (!$event->getData()->getAgency()) {
                $event->getForm()
                    ->add('agency', 'genemu_jqueryselect2_entity', array(
                        'class' => 'EnigmaticCRMBundle:Agency',
                        'multiple' => false,
                        'expanded' => false,
                        'label' => 'enigmatic.crm.agency_account.form.field.agency.label',
                        'empty_value' => 'enigmatic.crm.agency_account.form.field.agency.empty_value',
                        'required' => true,
                        'query_builder' => function (EntityRepository $er) use ($event) {

                            $_sub_query = $er->createQueryBuilder('sub_agency')
                                ->select('DISTINCT sub_agency.id')
                                ->leftJoin('sub_agency.accounts', 'sub_agency_account')
                                ->where('sub_agency_account.account = :account')
                                ->getQuery()->getDQL();

                            return $er->createQueryBuilder('agency')
                                ->where('agency.id NOT IN (' . $_sub_query . ')')
                                ->setParameter('account', $event->getData()->getAccount()->getId())
                                ->orderBy('agency.name', 'ASC');
                        },
                    ));
                }
                $event->getForm()
                    ->add('potential', 'genemu_jqueryselect2_choice', array(
                        'choices'       => array(
                            AgencyAccount::TOP_150   =>  'enigmatic.crm.agency_account.form.field.potential.'.AgencyAccount::TOP_150,
                            AgencyAccount::TOP_100   =>  'enigmatic.crm.agency_account.form.field.potential.'.AgencyAccount::TOP_100,
                            AgencyAccount::OTHER   =>  'enigmatic.crm.agency_account.form.field.potential.'.AgencyAccount::OTHER,
                        ),
                        'required'      => true,
                        'multiple'      => false,
                        'expanded'      => false,
                        'label'         => 'enigmatic.crm.agency_account.form.field.potential.label',
                    ))
                    ->add('description', 'textarea', array (
                        'label'         => 'enigmatic.crm.agency_account.form.field.description.label',
                        'required'      => false,
                    ))
                    ->add('turnovers', 'collection', array(
                        'type'          => 'enigmatic_crm_agency_account_turnover',
                        'required'     => false,
                        'allow_add'     => true,
                        'allow_delete'  => true,
                        'label'         => 'enigmatic.crm.agency_account.form.field.turnovers.label',
                        'prototype'         => true,
                        'prototype_name'    => '__turnover__',
                        'attr'              => array(
                            'class'             => 'form_turnover',
                        )
                    ));
        });

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use($options) {
                if (count($event->getData()->getTurnovers())) {
                    foreach($event->getData()->getTurnovers() as $turnover) {
                        $turnover->setAgencyAccount($event->getData());
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
            'data_class' => 'Enigmatic\CRMBundle\Entity\AgencyAccount',
            'cascade_validation' => true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_agency_account';
    }
}
