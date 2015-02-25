<?php

namespace Enigmatic\CityBundle\Form\Type;

use Enigmatic\CityBundle\DataTransformer\CityTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CityType extends AbstractType
{
    /**
     * @var CityTransformer
     */
    private $cityTransformer;

    /**
     * @param CityTransformer $cityTransformer
     */
    public function __construct(CityTransformer $cityTransformer)
    {
        $this->cityTransformer = $cityTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
//        $transformer = new IssueToNumberTransformer($this->om);
        $builder->addModelTransformer($this->cityTransformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'invalid_message' => 'The selected issue does not exist',
        ));
    }

    public function getParent()
    {
        return 'text';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enigmatic_city';
    }
}