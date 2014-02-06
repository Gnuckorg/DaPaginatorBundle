<?php

namespace Da\PaginatorBundle\Pagination;

/**
 * TwigPaginationExtension is the Twig extention for the pagination.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class TwigPaginationExtension extends \Twig_Extension
{
	/**
     * The paginator.
     *
     * @var PaginatorInterface
     */
    private $paginator;

	/**
     * Constructor.
     *
     * @param PaginatorInterface $paginator The paginator.
     */
    public function __construct(
        PaginatorInterface $paginator
    )
    {
        $this->paginator = $paginator;
    }

    /**
     * {@inheritdoc}
     */
    public function initRuntime(\Twig_Environment $environment)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getTokenParsers()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getNodeVisitors()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getTests()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getOperators()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array('da' => array('paginator' => $this->paginator));
    }
}
