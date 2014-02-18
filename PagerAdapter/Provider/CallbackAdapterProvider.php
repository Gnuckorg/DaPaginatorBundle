<?php

namespace Da\PaginatorBundle\PagerAdapter\Provider;

/**
 * Provider for callback adapter.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class CallbackAdapterProvider extends AbstractAdapterProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getAdapterClassName()
    {
        return 'Pagerfanta\Adapter\CallbackAdapter';
    }
}