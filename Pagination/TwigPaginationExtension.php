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
    public function getName()
    {
        return 'da_paginator';
    }

    /**
     * {@inheritdoc}
     */
    public function getGlobals()
    {
        return array('da' => array('paginator' => $this->paginator));
    }
}
