<?php

namespace Da\PaginatorBundle\Pagination;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * TwigPaginationExtension is the Twig extention for the pagination.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class TwigPaginationExtension extends \Twig_Extension
{
    /**
     * The dependency injection container.
     *
     * @var ContainerInterface
     */
    private $container;

    /**
     * Constructor.
     *
     * @param ContainerInterface $container The dependency injection container.
     */
    public function __construct(
        ContainerInterface $container
    )
    {
        $this->container = $container;
    }

    /**
     * Get the paginator.
     *
     * @return PaginatorInterface The paginator.
     */
    public function getPaginator()
    {
        return $this->container->get('da_paginator.paginator');
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
        return array('da_paginator' => $this->getPaginator());
    }
}
