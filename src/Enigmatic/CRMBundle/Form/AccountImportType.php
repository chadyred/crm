<?php

namespace Enigmatic\CRMBundle\Form;

use Doctrine\ORM\EntityRepository;
use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Enigmatic\CRMBundle\Manager\UserManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Validator\Constraints\File;

class AccountImportType extends AbstractType
{
    protected $authorizationChecker;
    protected $userManager;

    /**
     * @param AuthorizationChecker $authorizationChecker
     * @param UserManager $userManager
     */
    public function __construct(AuthorizationChecker $authorizationChecker, UserManager $userManager) {
        $this->authorizationChecker  = $authorizationChecker;
        $this->userManager  = $userManager;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'required'      => true,
                'label'         => 'enigmatic.crm.account_import.form.field.file.label',
                'constraints' => array(
                    new File(array(
                        'maxSize' => '8M',
                        'mimeTypesMessage' => 'enigmatic.crm.account_import.file.mime_type',
                        'mimeTypes' => array(
                            'text/plain',
                        ))
                    ),
                )
            ))
//            ->add('sync_societe_com', 'choice', array(
//                'choices'       => array(
//                    true   =>   'enigmatic.crm.account_import.form.field.sync_societe_com.label',
//                ),
//                'required'      => false,
//                'multiple'      => true,
//                'expanded'      => true,
//                'label'         => null,
//            ))
        ;

        if ($this->authorizationChecker->isGranted('ROLE_RS')) {
            $builder
                ->add('agencies', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:Agency',
                    'multiple' => true,
                    'expanded' => false,
                    'label'    => 'enigmatic.crm.account_import.form.field.agencies.label',
                    'required' => true
                ))
                ->add('owners', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:User',
                    'property' => 'userWithAgencyName',
                    'multiple' => true,
                    'expanded' => false,
                    'label'    => 'enigmatic.crm.account_import.form.field.owners.label',
                    'required' => true
                ));
        }
        elseif ($this->authorizationChecker->isGranted('ROLE_RCA')) {
            $builder
                ->add('owners', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:User',
                    'property' => 'userWithAgencyName',
                    'multiple' => true,
                    'expanded' => false,
                    'label'    => 'enigmatic.crm.account_import.form.field.owners.label',
                    'required' => true,
                    'query_builder' => function (EntityRepository $er) {
                        $params = array();
                        $params['search']['agency'] = ($this->userManager->getCurrent()?$this->userManager->getCurrent()->getAgency():null);
                        return $er->getER($params);
                    },
                ));
        }
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'            => null,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_account_import';
    }
}
