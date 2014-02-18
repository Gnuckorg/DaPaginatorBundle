<?php

namespace Da\PaginatorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class SetPaginatorPagerAdapterProviderPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('da_paginator.paginator')) {
            return;
        }

        $definition = $container->getDefinition('da_paginator.paginator');

        $taggedServices = $container->findTaggedServiceIds('da_paginator.pager_adapter_provider');
        foreach ($taggedServices as $id => $tagAttributes) {
        	foreach ($tagAttributes as $tagAttribute) {
	            $definition->addMethodCall(
	                'setPagerAdapaterProvider',
	                array(
                        $tagAttribute['id'], 
                        new Reference($id)      
                    )
	            );
	        }
        }
    }
}