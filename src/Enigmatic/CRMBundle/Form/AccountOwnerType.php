<?php

namespace Enigmatic\CRMBundle\Form;

use Doctrine\ORM\EntityRepository;
use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Enigmatic\CRMBundle\Manager\UserManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

class AccountOwnerType extends AbstractType
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
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder) {
            $event->getForm()
                ->add('user', 'genemu_jqueryselect2_entity', array(
                    'class' => 'EnigmaticCRMBundle:User',
                    'property' => 'userWithAgencyName',
                    'multiple' => false,
                    'expanded' => false,
                    'label' => 'enigmatic.crm.account_owner.form.field.user.label',
                    'empty_value' => 'enigmatic.crm.account_owner.form.field.user.empty_value',
                    'required' => true,
                    'query_builder' => function(EntityRepository $er) use($event) {

                        $_sub_query_agency = $er->createQueryBuilder('za')
                            ->select('DISTINCT ss_agency.id')
                            ->from('EnigmaticCRMBundle:Agency', 'ss_agency')
                            ->leftJoin('ss_agency.accounts', 'ss_agency_account')
                            ->where('ss_agency_account.account = :account')
                            ->getQuery()->getDQL();

                        $_sub_query_user_ok = $er->createQueryBuilder('sub_user')
                            ->select('DISTINCT sub_user.id')
                            ->leftJoin('sub_user.assignedAccount', 'sub_user_account')
                            ->leftJoin('sub_user_account.end', 'sub_user_account_end')
                            ->leftJoin('sub_user.agencies', 'sub_user_agencies')
                            ->leftJoin('sub_user_agencies.end', 'sub_user_agencies_end')
                            ->leftJoin('sub_user_agencies.agency', 'agency')
                            ->where('agency IN ('.$_sub_query_agency.')');
                            ;

                        if ($this->authorizationChecker->isGranted('ROLE_RCA') && !$this->authorizationChecker->isGranted('ROLE_RS'))
                            $_sub_query_user_ok->andWhere('agency = :agency');

                        $_sub_query_user_ok->getQuery()->getDQL();

                        $_sub_query_user_not_ok = $er->createQueryBuilder('sub_user_not_ok')
                            ->select('DISTINCT sub_user_not_ok.id')
                            ->leftJoin('sub_user_not_ok.assignedAccount', 'sub_user_not_ok_account')
                            ->leftJoin('sub_user_not_ok_account.end', 'sub_user_not_ok_account_end')
                            ->leftJoin('sub_user_not_ok.agencies', 'sub_user_not_ok_agencies')
                            ->leftJoin('sub_user_not_ok_agencies.end', 'sub_user_not_ok_agencies_end')
                            ->leftJoin('sub_user_not_ok_agencies.agency', 'sub_user_not_ok_agency')
                            ->where('sub_user_not_ok_account.account = :account')
                            ->andWhere('sub_user_not_ok_account_end IS NULL')
                            ->getQuery()->getDQL();

                        $query = $er->createQueryBuilder('user')
                            ->where('user.id IN ('.$_sub_query_user_ok.')')
                            ->andWhere('user.id NOT IN ('.$_sub_query_user_not_ok.')')
                            ->setParameter('account', $event->getData()->getAccount()->getId())
                            ->addOrderBy('user.name', 'ASC')
                            ->addOrderBy('user.firstname', 'ASC');

                        if ($this->authorizationChecker->isGranted('ROLE_RCA') && !$this->authorizationChecker->isGranted('ROLE_RS'))
                            $query ->setParameter('agency', $this->userManager->getCurrent()->getAgency());

                        return $query;
                    }
                ));
        });
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Enigmatic\CRMBundle\Entity\AccountOwner'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_crm_account_owner';
    }
}
