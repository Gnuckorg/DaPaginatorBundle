<?php

namespace Da\PaginatorBundle\Pagination;

/**
 * The interface that a class should implements to be
 * used as a paginator.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
interface PaginatorInterface
{
    /**
     * Add a paginated content.
     */
    function addPaginatedContent();
}