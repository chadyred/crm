<?php
namespace Enigmatic\CRMBundle\ParamConverter;

use Enigmatic\CRMBundle\Entity\CampaignMailing;
use Doctrine\ORM\EntityManager;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class CampaignMailingParamConverter implements ParamConverterInterface
{
    protected $em;
    protected $class;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->class = 'EnigmaticCRMBundle:CampaignMailing';
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() == $this->class;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $campaignMailing = $this->em->getRepository($this->class)->find($request->attributes->get($configuration->getName()));
        $request->attributes->set($configuration->getName(), $campaignMailing);
        return ($campaignMailing instanceof CampaignMailing)?true:false;
    }
}