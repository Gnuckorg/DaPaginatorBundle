<?php

namespace Da\PaginatorBundle\Pagination;

use Pagerfanta\Pagerfanta;

/**
 * The interface that a class should implements to be
 * used as a paginated content.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
interface PaginatedContentInterface extends \IteratorAggregate
{
    /**
     * Get the number of results.
     *
     * @return integer The number of results.
     */
    function getNbResults();

	/**
     * Get the offset.
     *
     * @return integer The offset.
     */
    function getOffset();

    /**
     * Get the limit.
     *
     * @return integer The limit.
     */
    function getLimit();

    /**
     * Set the offset and limit of the pagination.
     *
     * @param integer $offset The offset.
     * @param integer $limit  The limit.
     *
     * @return PaginatedContentInterface This.
     */
    function setOffsetLimit($offset, $limit);

    /**
     * Get the page.
     *
     * @return integer The page.
     */
    function getPage();

    /**
     * Get the number of rows per page.
     *
     * @return integer The number of rows per page.
     */
    function getPerPage();

    /**
     * Set the page and per page of the pagination.
     *
     * @param integer $page    The page.
     * @param integer $perPage The number of rows per page.
     *
     * @return PaginatedContentInterface This.
     */
    function setPagePerPage($page, $perPage);

	/**
     * Get the pager.
     *
     * @return Pagerfanta The pager.
     */
    function getPager();

    /**
     * Set the pager.
     *
     * @param Pagerfanta $pager The pager.
     *
     * @return PaginatedContentInterface This.
     */
    function setPager(Pagerfanta $pager);

    /**
     * Get the route generator callback.
     *
     * @return \Closure The route generator callback.
     */
    function getRouteGenerator();

    /**
     * Set the route generator callback.
     *
     * @param \Closure $routeGenerator The route generator callback.
     *
     * @return PaginatedContentInterface This.
     */
    function setRouteGenerator(\Closure $routeGenerator);

    /**
     * Get the displayed fields.
     *
     * @return array The fields in the format name => title.
     */
    function getFields();

    /**
     * Set the displayed fields.
     *
     * @param array $fields The fields in the format name => title.
     *
     * @return PaginatedContentInterface This.
     */
    function setFields(array $fields);
}