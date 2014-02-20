<?php

namespace Da\PaginatorBundle\Pagination;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\request;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Da\PaginatorBundle\PagerAdapter\Provider\PagerAdapterProviderInterface;
use Da\PaginatorBundle\View\Renderer\RendererInterface;

/**
 * Paginator is a basic implementation of a paginator.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class Paginator implements PaginatorInterface
{
    /**
     * The pagers.
     *
     * @var array
     */
    private $pagers = array();

    /**
     * The paginated contents.
     *
     * @var array
     */
    private $contents = array();

    /**
     * The views for the paginated contents.
     *
     * @var array
     */
    private $views = array();

    /**
     * The route generators for the paginated contents.
     *
     * @var array
     */
    private $routeGenerators = array();

    /**
     * The providers of pager adapater.
     *
     * @var array
     */
    private $pagerAdapterProviders = array();

    /**
     * The providers of renderer.
     *
     * @var array
     */
    private $rendererProviders = array();

    /**
     * The router.
     *
     * @var RouterInterface
     */
    private $router;

    /**
     * The request.
     *
     * @var Request
     */
    private $request;

    /**
     * Constructor.
     *
     * @param RouterInterface $router  The router.
     * @param Request         $request The request.
     */
    public function __construct(
        RouterInterface $router,
        Request $request
    )
    {
        $this->router = $router;
        $this->request = $request;
    }

    /**
     * Set a provider of pager adapater.
     *
     * @param string                        $id                   The id of the provider.
     * @param PagerAdapterProviderInterface $pagerAdapterProvider The provider.
     */
    public function setPagerAdapaterProvider($id, PagerAdapterProviderInterface $pagerAdapterProvider)
    {
        $this->pagerAdapterProviders[$id] = $pagerAdapterProvider;
    }

    /**
     * Set a renderer.
     *
     * @param string            $id       The id of the renderer.
     * @param RendererInterface $renderer The renderer.
     */
    public function setRenderer($id, RendererInterface $renderer)
    {
        $this->renderers[$id] = $renderer;
    }

    /**
     * Create a new pager adapter.
     *
     * @param string $pagerAdapterId        The id of the pager adapter.
     * @param array  $pagerAdapterArguments The arguments for the pager adapter creation.
     */
    protected function createPagerAdapter($pagerAdapterId, array $pagerAdapterArguments = array())
    {
        if (!isset($this->pagerAdapterProviders[$pagerAdapterId])) {
            throw new \InvalidArgumentException(sprintf(
                'The pager adapter "%s" does not exist.',
                $pagerAdapterId
            ));
        }

        return $this->pagerAdapterProviders[$pagerAdapterId]
            ->create($pagerAdapterArguments)
        ;
    }

    /**
     * Get a pager.
     *
     * @param string $contentId The id of the content.
     */
    protected function getPager($contentId)
    {
        if (!isset($this->pagers[$contentId])) {
            throw new \InvalidArgumentException(sprintf(
                'The paginated content "%s" has not been defined.',
                $contentId
            ));
        }

        return $this->pagers[$contentId];
    }

    /**
     * Get a paginated content.
     *
     * @param string $contentId The id of the content.
     */
    protected function getContent($contentId, $viewId)
    {
        // Check the existence of the content.
        $this->getPager($contentId);

        if (!isset($this->contents[$contentId][$viewId])) {
            throw new \InvalidArgumentException(sprintf(
                'The view "%s" has not been defined for the paginated content "%s".',
                $viewId,
                $contentId
            ));
        }

        return $this->contents[$contentId][$viewId];
    }

    /**
     * Get a paginated content view.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId    The id of the view.
     */
    public function getContentView($contentId, $viewId)
    {
        // Check the existence of the content.
        $this->getPager($contentId);

        if (!isset($this->views[$contentId][$viewId])) {
            throw new \InvalidArgumentException(sprintf(
                'The view "%s" has not been defined for the paginated content "%s".',
                $viewId,
                $contentId
            ));
        }

        return $this->views[$contentId][$viewId];
    }

    /**
     * Set a paginated content view.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId    The id of the view.
     * @param array  $content   The content.
     */
    public function setContent($contentId, $viewId, \ArrayAcces $content)
    {
        // Check the existence of the content view.
        $this->getContent($contentId, $viewId);

        $this->contents[$contentId][$viewId] = $content;
    }

	/**
     * {@inheritdoc}
     */
    public function definePerPagePaginatedContent($contentId, $pagerAdapterId, array $pagerAdapterArguments = array(), $currentPage, $maxPerPage, $currentPageLabel = 'page', $maxPerPageLabel = 'per_page')
    {
        $pagerAdapter = $this->createPagerAdapter($pagerAdapterId, $pagerAdapterArguments);

        $pager = new Pagerfanta($pagerAdapter);
        $pager->setMaxPerPage($maxPerPage);
        $pager->setCurrentPage($currentPage);

        $router = $this->router;
        $route = $this->request->get('_route');
        $parameters = $this->request->query->all();
        $routeGenerator = function($page) use ($router, $route, $pager, $parameters, $currentPageLabel, $maxPerPageLabel) {
            $parameters = array_merge(
                $parameters,
                array($currentPageLabel => $page, $maxPerPageLabel => $pager->getMaxPerPage())
            );

            return $router->generate($route, $parameters);
        };

        $this->pagers[$contentId] = $pager;
        $this->routeGenerators[$contentId] = $routeGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function defineOffsetPaginatedContent($contentId, $pagerAdapterId, array $pagerAdapterArguments = array(), $offset, $limit, $offsetLabel = 'offset', $limitLabel = 'limit')
    {
        $pagerAdapter = $this->createPagerAdapter($pagerAdapterId, $pagerAdapterArguments);

        $pager = new Pagerfanta($pagerAdapter);
        $pager->setMaxPerPage($limit);
        $pager->setCurrentPage(floor($offset / $limit) + 1);

        $router = $this->router;
        $route = $this->request->get('_route');
        $parameters = $this->request->query->all();
        $routeGenerator = function($page) use ($router, $route, $pager, $parameters, $offsetLabel, $limitLabel) {
            $parameters = array_merge(
                $parameters,
                array($offsetLabel => ($page - 1) * $pager->getMaxPerPage(), $limitLabel => $pager->getMaxPerPage())
            );

            return $router->generate($route, $parameters);
        };

        $this->pagers[$contentId] = $pager;
        $this->routeGenerators[$contentId] = $routeGenerator;
    }

    /**
     * {@inheritdoc}
     */
    public function definePaginatedContentView($contentId, $viewId, array $fields)
    {
        $pager = $this->getPager($contentId);

        if (!isset($this->contents[$contentId])) {
            $this->contents[$contentId] = array();
        }
        if (!isset($this->views[$contentId])) {
            $this->views[$contentId] = array();
        }

        foreach ($fields as $itemName => $itemTitle) {
            if (!is_string($itemName) || !is_string($itemTitle)) {
                throw new \InvalidArgumentException('The fields must be an associative array of field names.');
            }
        }

        $this->contents[$contentId][$viewId] = $pager->getIterator();
        $this->views[$contentId][$viewId] = $fields;
    }

    /**
     * Get a renderer.
     *
     * @param string $rendererId The id of the renderer.
     */
    protected function getRenderer($rendererId)
    {
        if (!isset($this->renderers[$rendererId])) {
            throw new \InvalidArgumentException(sprintf(
                'The view renderer "%s" does not exist.',
                $rendererId
            ));
        }

        return $this->renderers[$rendererId];
    }

    /**
     * {@inheritdoc}
     */
    public function renderContentView($contentId, $viewId, $rendererId)
    {
        $renderer = $this->getRenderer($rendererId);
        $pager = $this->getPager($contentId);
        $content = $this->getContent($contentId, $viewId);
        $fields = $this->getContentView($contentId, $viewId);

        return $renderer->render($pager, $content, $this->routeGenerators[$contentId], $fields);
    }
}
