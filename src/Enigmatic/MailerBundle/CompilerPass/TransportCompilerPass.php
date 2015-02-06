<?php

namespace Enigmatic\MailerBundle\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class TransportCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('enigmatic_mailer.transports')) {
            return null;
        }

        $definition = $container->getDefinition(
            'enigmatic_mailer.transports'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'enigmatic_mailer.transport'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addTransport',
                array(new Reference($id), $attributes[0]["alias"])
            );
        }
    }
}