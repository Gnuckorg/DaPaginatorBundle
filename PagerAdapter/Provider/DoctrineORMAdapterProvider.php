<?php

namespace Da\PaginatorBundle\PagerAdapter\Provider;

/**
 * Provider for Doctrine's ORM adapter.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class DoctrineORMAdapterProvider extends AbstractAdapterProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getAdapterClassName()
    {
        return 'Pagerfanta\Adapter\DoctrineORMAdapter';
    }
}