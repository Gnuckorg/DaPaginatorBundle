<?php

namespace Da\PaginatorBundle\Pagination;

use Pagerfanta\Pagerfanta;

/**
 * PaginatedContent is a basic implementation of a paginated content.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class PaginatedContent implements PaginatedContentInterface
{
    /**
     * The pager.
     *
     * @var Pagerfanta
     */
    private $pager;

    /**
     * The route generator callback.
     *
     * @var \Closure
     */
    private $routeGenerator;

    /**
     * The displayed fields.
     *
     * @var array
     */
    private $fields = array();

    /**
     * The offset.
     *
     * @var integer
     */
    private $offset;

    /**
     * The limit.
     *
     * @var integer
     */
    private $limit;

    /**
     * {@inheritdoc}
     */
    public function getIterator() 
    {
        return $this->pager;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function setOffsetLimit($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = max(1, $limit);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPage()
    {
        return floor($this->offset / $this->limit) + 1;
    }

    /**
     * {@inheritdoc}
     */
    public function getPerPage()
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function setPagePerPage($page, $perPage)
    {
        $this->limit = $perPage;
        $this->offset = (max(1, $page) - 1) * $perPage;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPager()
    {
        return $this->pager;
    }

    /**
     * {@inheritdoc}
     */
    public function setPager(Pagerfanta $pager)
    {
        $this->pager = $pager;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getRouteGenerator()
    {
        return $this->routeGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function setRouteGenerator(\Closure $routeGenerator)
    {
        $this->routeGenerator = $routeGenerator;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * {@inheritdoc}
     */
    public function setFields(array $fields)
    {
        $this->fields = $fields;

        return $this;
    }
}