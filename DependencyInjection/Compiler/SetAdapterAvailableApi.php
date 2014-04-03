<?php

namespace Da\PaginatorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class SetAdapterAvailableApi implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('da_paginator.pager_adapter_provider.api')) {
            return;
        }

        $definition = $container->getDefinition('da_paginator.pager_adapter_provider.api');

        $taggedServices = $container->findTaggedServiceIds('da_api_client.api');
        foreach ($taggedServices as $id => $tagAttributes) {
        	foreach ($tagAttributes as $tagAttribute) {
	            $definition->addMethodCall(
	                'setApiClient',
	                array(
                        $tagAttribute['name'],
                        new Reference($id)     
                    )
	            );
	        }
        }
    }
}