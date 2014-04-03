<?php

namespace Da\PaginatorBundle\PagerAdapter\Provider;

/**
 * The interface that a class should implements to be
 * used as provider of pager adapter.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
interface PagerAdapterProviderInterface
{
    /**
     * Create a new adapter.
     *
     * @param array   $arguments        The arguments for the constructor of the adapter.
     * @param string  $offsetLabel      The label for the pagination offset.
     * @param string  $limitLabel       The label for the pagination limit.
     * @param boolean $isPerPagePattern Whether or not it is a per page pattern (not an offset limit one).
     *
     * @return \Pagerfanta\Adapter\AdapterInterface The adapter.
     */
    function create(array $arguments = array(), $offsetLabel, $limitLabel, $isPerPagePattern);
}