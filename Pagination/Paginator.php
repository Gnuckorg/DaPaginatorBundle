<?php

namespace Da\PaginatorBundle\Pagination;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Request;
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
     * The router.
     *
     * @var RouterInterface
     */
    protected $router;

    /**
     * The request.
     *
     * @var Request
     */
    protected $request;

    /**
     * The class for the paginated content.
     *
     * @var string
     */
    protected $paginatedContentClass;

    /**
     * The providers of pager adapater.
     *
     * @var array
     */
    private $pagerAdapterProviders = array();

    /**
     * The renderers.
     *
     * @var array
     */
    private $renderers = array();

    /**
     * Constructor.
     *
     * @param RouterInterface $router  The router.
     * @param Request         $request The request.
     */
    public function __construct(
        RouterInterface $router,
        Request $request,
        $paginatedContentClass
    )
    {
        $this->router = $router;
        $this->request = $request;
        $this->paginatedContentClass = $paginatedContentClass;
    }

    /**
     * {@inheritdoc}
     */
    public function setPagerAdapaterProvider($id, PagerAdapterProviderInterface $pagerAdapterProvider)
    {
        $this->pagerAdapterProviders[$id] = $pagerAdapterProvider;
    }

    /**
     * Create a new pager adapter.
     *
     * @param string $pagerAdapterId        The id of the pager adapter.
     * @param array  $pagerAdapterArguments The arguments for the pager adapter creation.
     */
    protected function createPagerAdapter(
        $pagerAdapterId,
        array $pagerAdapterArguments,
        $offsetLabel,
        $limitLabel,
        $isPerPagePattern = false
    )
    {
        if (!isset($this->pagerAdapterProviders[$pagerAdapterId])) {
            throw new \InvalidArgumentException(sprintf(
                'The pager adapter "%s" does not exist.',
                $pagerAdapterId
            ));
        }

        return $this->pagerAdapterProviders[$pagerAdapterId]
            ->create($pagerAdapterArguments, $offsetLabel, $limitLabel, $isPerPagePattern)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setRenderer($id, RendererInterface $renderer)
    {
        $this->renderers[$id] = $renderer;
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
    public function definePerPagePaginatedContent(
        array $fields,
        $pagerAdapterId,
        array $pagerAdapterArguments = array(),
        $currentPageLabel = 'page',
        $maxPerPageLabel = 'per_page'
    )
    {
        $currentPage = $this->request->query->get($currentPageLabel, 0);
        $maxPerPage = $this->request->query->get($maxPerPageLabel, 20);

        // Displayed fields checking.
        $this->checkFields($fields);

        // Pager definition.
        $pagerAdapter = $this->createPagerAdapter(
            $pagerAdapterId,
            $pagerAdapterArguments,
            $currentPageLabel,
            $maxPerPageLabel,
            true
        );
        $pager = new Pagerfanta($pagerAdapter);
        $pager->setMaxPerPage($maxPerPage);
        $pager->setCurrentPage($currentPage);

        // Pages routing building.
        $router = $this->router;
        $route = $this->request->get('_route');
        $parameters = array_merge($this->request->query->all(), $this->request->get('_route_params'));
        $routeGenerator = function($page) use ($router, $route, $pager, $parameters, $currentPageLabel, $maxPerPageLabel) {
            $parameters = array_merge(
                $parameters,
                array($currentPageLabel => $page, $maxPerPageLabel => $pager->getMaxPerPage())
            );

            return $router->generate($route, $parameters);
        };

        $this->pagers[$contentId] = $pager;
        $this->routeGenerators[$contentId] = $routeGenerator;

        // Content definition.
        $content = new $this->paginatedContentClass();
        
        return $content
            ->setPagePerPage($currentPage, $maxPerPage)
            ->setPager($pager)
            ->setRouteGenerator($routeGenerator)
            ->setFields($fields)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function defineOffsetPaginatedContent(
        array $fields,
        $pagerAdapterId,
        array $pagerAdapterArguments = array(),
        $offsetLabel = 'offset',
        $limitLabel = 'limit'
    )
    {
        $offset = $this->request->query->get($offsetLabel, 0);
        $limit = $this->request->query->get($limitLabel, 20);

        // Displayed fields checking.
        $this->checkFields($fields);

        // Pager definition.
        $pagerAdapter = $this->createPagerAdapter(
            $pagerAdapterId,
            $pagerAdapterArguments,
            $offsetLabel,
            $limitLabel,
            false
        );
        $pager = new Pagerfanta($pagerAdapter);
        $pager->setMaxPerPage($limit);
        $pager->setCurrentPage(floor($offset / $limit) + 1);

        // Pages routing building.
        $router = $this->router;
        $route = $this->request->get('_route');
        $parameters = array_merge($this->request->query->all(), $this->request->get('_route_params'));
        $routeGenerator = function($page) use ($router, $route, $pager, $parameters, $offsetLabel, $limitLabel) {
            $parameters = array_merge(
                $parameters,
                array($offsetLabel => ($page - 1) * $pager->getMaxPerPage(), $limitLabel => $pager->getMaxPerPage())
            );

            return $router->generate($route, $parameters);
        };

        // Content definition.
        $content = new $this->paginatedContentClass();
        
        return $content
            ->setOffsetLimit($offset, $limit)
            ->setPager($pager)
            ->setRouteGenerator($routeGenerator)
            ->setFields($fields)
        ;
    }

    /**
     * Check the format of the given displayed fields.
     *
     * @throws \InvalidArgumentException If the format is invalid.
     */
    protected function checkFields(array $fields)
    {
        foreach ($fields as $itemName => $itemTitle) {
            if (!is_string($itemName) || !is_string($itemTitle)) {
                throw new \InvalidArgumentException('The fields must be an associative array of field names.');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function render(PaginatedContentInterface $content, $rendererId, $macroFileLogicalName = '')
    {
        $renderer = $this->getRenderer($rendererId);
        $pager = $content->getPager();
        $fields = $content->getFields();
        $routeGenerator = $content->getRouteGenerator();
        $content = iterator_to_array($content);

        return $renderer->render(
            $pager,
            $content,
            $routeGenerator,
            $fields,
            $macroFileLogicalName
        );
    }
}
