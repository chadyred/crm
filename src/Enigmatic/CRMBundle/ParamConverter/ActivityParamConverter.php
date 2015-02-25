<?php
namespace Enigmatic\CRMBundle\ParamConverter;

use Doctrine\ORM\EntityManager;

use Enigmatic\CRMBundle\Entity\Activity;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ActivityParamConverter implements ParamConverterInterface
{
    protected $em;
    protected $class;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->class = 'EnigmaticCRMBundle:Activity';
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() == $this->class;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $activity = $this->em->getRepository($this->class)->find($request->attributes->get($configuration->getName()));
        $request->attributes->set($configuration->getName(), $activity);
        return ($activity instanceof Activity)?true:false;
    }
}