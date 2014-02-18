<?php

namespace Da\PaginatorBundle\PagerAdapter\Provider;

/**
 * Provider for Doctrine's MongoDB ODM adapter.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class DoctrineODMMongoDBAdapterProvider extends AbstractAdapterProvider
{
    /**
     * {@inheritdoc}
     */
    protected function getAdapterClassName()
    {
        return 'Pagerfanta\Adapter\DoctrineODMMongoDBAdapter';
    }
}