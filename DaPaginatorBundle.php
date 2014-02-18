<?php

namespace Da\PaginatorBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Da\PaginatorBundle\DependencyInjection\DaPaginatorExtension;
use Da\PaginatorBundle\DependencyInjection\Compiler\SetPaginatorPagerAdapterProviderPass;
use Da\PaginatorBundle\DependencyInjection\Compiler\SetPaginatorRendererPass;

class DaPaginatorBundle extends Bundle
{
	/**
	 * Constructor.
	 */
    public function __construct()
    {
        $this->extension = new DaPaginatorExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SetPaginatorPagerAdapterProviderPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
        $container->addCompilerPass(new SetPaginatorRendererPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION);
    }
}
