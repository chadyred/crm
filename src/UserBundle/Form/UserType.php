<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array (
                'label'     => 'Email',
                'required'  => true,
            ))
        ;

        if ($options['password']) {
            $builder
                ->add('plainPassword', 'repeated', array(
                    'type'              => 'password',
                    'first_options'     => array('label' => 'Mot de passe : '),
                    'second_options'    => array('label' => 'Vérification : '),
                    'invalid_message'   => 'fos_user.password.mismatch',
                    'required'          => false
                ))
            ;
        }

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'    => 'UserBundle\Entity\User',
            'password'      => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'userbundle_user';
    }
}
