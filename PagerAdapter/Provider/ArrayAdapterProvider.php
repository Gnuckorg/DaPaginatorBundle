<?php

namespace Da\PaginatorBundle\PagerAdapter\Provider;

/**
 * Provider for array adapter.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class ArrayAdapterProvider extends AbstractAdapterProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getAdapterClassName()
    {
        return 'Pagerfanta\Adapter\ArrayAdapter';
    }
}