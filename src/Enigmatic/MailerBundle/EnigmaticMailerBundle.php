<?php

namespace Enigmatic\MailerBundle;

use Enigmatic\MailerBundle\CompilerPass\TransportCompilerPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EnigmaticMailerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new TransportCompilerPass());
    }
}
