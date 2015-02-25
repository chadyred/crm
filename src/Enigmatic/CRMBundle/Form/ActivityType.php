<?php

namespace Enigmatic\CRMBundle\Form;

use Enigmatic\CRMBundle\Entity\Activity;
use Enigmatic\CRMBundle\Manager\ActivityTypeManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class ActivityType extends AbstractType
{
    protected $activityTypeManager;
    protected $translator;

    /**
     * @param ActivityTypeManager $activityTypeManager
     */
    public function __construct(ActivityTypeManager $activityTypeManager, Translator $translator)
    {
        $this->activityTypeManager = $activityTypeManager;
        $this->translator = $translator;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {

            $event->getForm()
                ->add('dateStart', 'datetime', array (
                    'label'         => (!(!$event->getData()->getId() && $event->getData()->getReplannedBy()))?'enigmatic.crm.activity.form.field.dateStart.label':'enigmatic.crm.activity.form.field.dateStart.replann.label',
                    'widget'        => 'single_text',
                    'input'         => 'datetime',
                    'format'        => 'dd-MM-yyyy H:m',
                    'required'      => true,
                    'attr'          => array(
                        'class'     => 'datetimepicker',
                        'placeholder'     => 'dd-mm-yyyy h:m',
                    )
                ));


            if (!(!$event->getData()->getId() && $event->getData()->getReplannedBy())) {
                $event->getForm()
                    ->add('type', 'genemu_jqueryselect2_entity', array(
                        'class' => 'EnigmaticCRMBundle:ActivityType',
                        'multiple' => false,
                        'expanded' => false,
                        'label' => 'enigmatic.crm.activity.form.field.type.label',
                        'empty_value' => 'enigmatic.crm.activity.form.field.type.empty_value',
                        'choices'  => $this->getArrayOfEntities(),
                        'required' => true
                    ))
                    ->add('comment', 'textarea', array (
                        'label'         => 'enigmatic.crm.activity.form.field.comment.label',
                        'required'      => false,
                    ));
            }

            if (!$event->getData()->getAccount() || $event->getData()->getId()) {
                $event->getForm()->add('account', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:Account',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'enigmatic.crm.activity.form.field.account.label',
                    'empty_value' => 'enigmatic.crm.activity.form.field.account.empty_value',
                    'required' => true,
                ));
            }

            if ($event->getData()->getId()) {
                $event->getForm()->add('dateEnd', 'datetime', array (
                    'label'         => 'enigmatic.crm.activity.form.field.dateEnd.label',
                    'widget'        => 'single_text',
                    'input'         => 'datetime',
                    'format'        => 'dd-MM-yyyy H:m',
                    'required'      => true,
                    'attr'          => array(
                        'class'     => 'datetimepicker',
                        'placeholder'     => 'dd-mm-yyyy h:m',
                    )
                ));
            }

            if (!$event->getData()->getUser()) {
                $event->getForm()->add('user', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:User',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'enigmatic.crm.activity.form.field.user.label',
                    'empty_value' => 'enigmatic.crm.activity.form.field.user.empty_value',
                    'required' => true
                ));
            }
        });

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use($options) {
                if (!$event->getData()->getId()) {
                    $date = clone $event->getData()->getDateStart();
                    $event->getData()->setDateEnd($date->modify('+30 min'));
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
            'data_class' => 'Enigmatic\CRMBundle\Entity\Activity'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_activity';
    }

    protected function getArrayOfEntities() {
        $activities = $this->activityTypeManager->getAll();
        $list = array();
        foreach($activities as $activity){
            $list[$this->translator->trans('enigmatic.crm.activity_type.field.type.'.$activity->getType())][] = $activity;
        }
        return $list;
    }
}
