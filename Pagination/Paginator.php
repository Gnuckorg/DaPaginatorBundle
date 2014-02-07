<?php

namespace Da\PaginatorBundle\Pagination;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Pagerfanta\View\TwitterBootstrapView;

/**
 * Paginator is a basic implementation of a paginator.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class Paginator implements PaginatorInterface
{
    /**
     * The paginated contents.
     *
     * @var array
     */
    private $contents = array();

    /**
     * The displayed contents.
     *
     * @var array
     */
    private $displayedContents = array();

    /**
     * The views for the paginated contents.
     *
     * @var array
     */
    private $views = array();

    /**
     * The pagination views.
     *
     * @var array
     */
    private $paginationViews = array();

    /**
     * The route generators for the paginated contents.
     *
     * @var array
     */
    private $routeGenerators = array();

	/**
     * {@inheritdoc}
     */
    public function addPaginatedContent($id, $adapterId, $currentPage, $maxPerPage, $offset, )
    {
        $qb = $this->getEm()->createQueryBuilder();
        $qb->select('j')->from('JMSJobQueueBundle:Job', 'j')
                ->where($qb->expr()->isNull('j.originalJob'))
                ->orderBy('j.id', 'desc');

        $pager = new Pagerfanta(new DoctrineORMAdapter($qb));
        $pager->setCurrentPage($currentPage);
        $pager->setMaxPerPage($maxPerPage);

        $pagerView = new TwitterBootstrapView();

        $router = $this->router;
        $request = $this->container->get('request');
        $route = $request->get('_route');
        $parameters = array_merge($request->query->all(), $request->attributes->all());
        $routeGenerator = function($page) use ($router, $route, $pager, $parameters) {
            $parameters = array_merge(
                $parameters,
                array('page' => $page, 'per_page' => $pager->getMaxPerPage())
            );
            
            return $router->generate($route, $parameters);
        };

        $this->contents[$id] = $pager;
        $this->paginationViews[$id] = $pagerView;
        $this->routeGenerators[$id] = $routeGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function addPaginatedContentView($contentId, $viewId, array $view)
    {
        if (!isset($this->views[$contentId])) {
            $this->views[$contentId] = array();
        }

        foreach ($view as $itemName => $itemTitle) {
            if (!is_string($itemName) || !is_string($itemTitle)) {
                throw new \InvalidArgumentException('The view must be an associative array of string values.');
            }
        }

        $this->views[$contentId][$viewId] = $view;
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayedViewContent($contentId, $viewId, array $displayedContent)
    {
        $this->displayedContents[$id] = $displayedContents;
    }

    /**
     * {@inheritdoc}
     */
    public function displayPages($id)
    {
        $pager = $this->contents[$id];

        if ($pager->haveToPaginate) {
            $pagerView = $this->views[$id];
            $routeGenerator = $this->routeGenerators[$id];

            return $pagerView->render($pager, $routeGenerator);//|raw }}
        }

        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function startTable($id)
    {
        $this->displayedContents[$id] = $displayedContents;
    }
}
