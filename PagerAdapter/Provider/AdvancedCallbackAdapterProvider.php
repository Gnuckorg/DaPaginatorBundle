<?php

namespace Da\PaginatorBundle\PagerAdapter\Provider;

/**
 * Provider for advanced callback adapter.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class AdvancedCallbackAdapterProvider extends AbstractAdapterProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getAdapterClassName()
    {
        return 'Da\PaginatorBundle\PagerAdapter\Adapter\AdvancedCallbackAdapter';
    }
}