<?php

namespace Enigmatic\CRMBundle\Form;

use Doctrine\ORM\EntityRepository;
use Enigmatic\CRMBundle\Manager\UserManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class ContactType extends AbstractType
{
    protected $authorizationChecker;
    protected $userManager;

    /**
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(AuthorizationChecker $authorizationChecker, UserManager $userManager)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->userManager = $userManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array (
                'label'         => 'enigmatic.crm.contact.form.field.firstname.label',
                'required'      => false,
            ))
            ->add('name', 'text', array (
                'label'         => 'enigmatic.crm.contact.form.field.name.label',
                'required'      => true,
            ))
            ->add('email', 'text', array (
                'label'         => 'enigmatic.crm.contact.form.field.email.label',
                'required'      => false,
            ))
            ->add('phones', 'collection', array(
                'type'          => 'enigmatic_crm_contact_phone',
                'required'     => false,
                'allow_add'     => true,
                'allow_delete'  => true,
                'label'         => 'enigmatic.crm.contact.form.field.phones.label',
                'cascade_validation' => true,
                'prototype'         => true,
                'prototype_name'    => '__contact_phone__',
                'attr'              => array(
                    'class'                     => 'form_collection',
                    'data-prototype_name'       => '__contact_phone__',
                    'data-min'                  => '0',
                    'data-max'                  => '5',
                    'data-auto_add'             => 'false',
                    'data-title'                => '',
                    'data-text_link_add'        => 'Ajouter un numéro',
                    'data-text_link_suppr'      => 'Supprimer ce numéro',
                )
            ))
            ->add('function', 'text', array (
                'label'         => 'enigmatic.crm.contact.form.field.function.label',
                'required'      => false,
            ))
            ->add('birthday', 'date', array (
                'label'         => 'enigmatic.crm.contact.form.field.birthday.label',
                'widget'        => 'single_text',
                'input'         => 'datetime',
                'format'        => 'dd-MM-yyyy',
                'required'      => false,
                'attr'          => array(
                    'class'         => 'datepicker',
                    'placeholder'   => 'dd-mm-yyyy',
                )
            ))
            ->add('address', 'text', array (
                'label'         => 'enigmatic.crm.contact.form.field.address.label',
                'required'      => false,
            ))
            ->add('addressCpl', 'text', array (
                'label'         => 'enigmatic.crm.contact.form.field.addressCpl.label',
                'required'      => false,
            ))
            ->add('city', 'enigmatic_city', array(
                'required'      => false,
                'label'         => 'enigmatic.crm.account.form.field.city.label',
            ))
            ->add('description', 'textarea', array (
                'label'         => 'enigmatic.crm.contact.form.field.description.label',
                'required'      => false,
            ))
        ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            if (!($event->getData()->getAccount() && !$event->getData()->getId())) {
                $event->getForm()->add('account', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:Account',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'enigmatic.crm.contact.form.field.account.label',
                    'empty_value' => 'enigmatic.crm.contact.form.field.account.empty_value',
                    'required' => true,
                    'query_builder' => function (EntityRepository $er) use ($event) {

                        $params = array();
                        if ($this->authorizationChecker->isGranted('ROLE_RCA') && !$this->authorizationChecker->isGranted('ROLE_RS'))
                            $params['search']['agency'] = ($this->userManager->getCurrent()?$this->userManager->getCurrent()->getAgency():null);
                        elseif ($this->authorizationChecker->isGranted('ROLE_CA') && !$this->authorizationChecker->isGranted('ROLE_RS')) {
                            $params['search']['agency'] = ($this->userManager->getCurrent()?$this->userManager->getCurrent()->getAgency():null);
                            $params['search']['account_owner'] = $this->userManager->getCurrent();
                        }

                        return $er->getER($params);
                    },
                ));
            }
        });

        $builder->addEventListener(
            FormEvents::SUBMIT,
            function (FormEvent $event) use($options) {
                if (count($event->getData()->getPhones()))
                foreach($event->getData()->getPhones() as $phone) {
                    $phone->setContact($event->getData());
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
            'data_class' => 'Enigmatic\CRMBundle\Entity\Contact',
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_contact';
    }
}
