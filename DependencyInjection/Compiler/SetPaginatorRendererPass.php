<?php

namespace Da\PaginatorBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class SetPaginatorRendererPass implements CompilerPassInterface
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

        $taggedServices = $container->findTaggedServiceIds('da_paginator.renderer');
        foreach ($taggedServices as $id => $tagAttributes) {
        	foreach ($tagAttributes as $tagAttribute) {
	            $definition->addMethodCall(
	                'setRenderer',
	                array(
                        $tagAttribute['id'], 
                        new Reference($id)      
                    )
	            );
	        }
        }
    }
}