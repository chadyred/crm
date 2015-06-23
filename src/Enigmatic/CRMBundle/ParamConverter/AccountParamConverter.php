<?php
namespace Enigmatic\CRMBundle\ParamConverter;

use Enigmatic\CRMBundle\Entity\Account;
use Doctrine\ORM\EntityManager;

use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class AccountParamConverter implements ParamConverterInterface
{
    protected $em;
    protected $class;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->class = 'EnigmaticCRMBundle:Account';
    }

    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() == $this->class;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $account = $this->em->getRepository($this->class)->find($request->attributes->get($configuration->getName()));
        $request->attributes->set($configuration->getName(), $account);
        return ($account instanceof Account)?true:false;
    }
}