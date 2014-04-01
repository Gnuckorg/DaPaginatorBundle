<?php

namespace Da\PaginatorBundle\Pagination;

use Da\PaginatorBundle\PagerAdapter\Provider\PagerAdapterProviderInterface;
use Da\PaginatorBundle\View\Renderer\RendererInterface;

/**
 * The interface that a class should implements to be
 * used as a paginator.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
interface PaginatorInterface
{
    /**
     * Set a provider of pager adapater.
     *
     * @param string                        $id                   The id of the provider.
     * @param PagerAdapterProviderInterface $pagerAdapterProvider The provider.
     */
    function setPagerAdapaterProvider($id, PagerAdapterProviderInterface $pagerAdapterProvider);

    /**
     * Set a renderer.
     *
     * @param string            $id       The id of the renderer.
     * @param RendererInterface $renderer The renderer.
     */
    function setRenderer($id, RendererInterface $renderer);

    /**
     * Define a paginated content.
     *
     * @param array   $fields                The fields in the format name => title.
     * @param string  $pagerAdapterId        The id of the adapter.
     * @param array   $pagerAdapterArguments The arguments of the adapater.
     * @param string  $currentPageLabel      The label of the current page query string parameter.
     * @param string  $maxPerPageLabel       The label of the number per page query string parameter.
     */
    function definePerPagePaginatedContent(
        array $contentId,
        $pagerAdapterId,
        array $pagerAdapterArguments = array(),
        $currentPageLabel = 'page',
        $maxPerPageLabel = 'per_page'
    );

    /**
     * Define a paginated content.
     *
     * @param array   $fields                The fields in the format name => title.
     * @param string  $pagerAdapterId        The id of the adapter.
     * @param array   $pagerAdapterArguments The arguments of the adapater.
     * @param string  $offsetLabel           The label of the number to skip query string parameter.
     * @param string  $limitLabel            The label of the number per page query string parameter.
     */
    function defineOffsetPaginatedContent(
        array $fields,
        $pagerAdapterId,
        array $pagerAdapterArguments = array(),
        $offsetLabel = 'offset',
        $limitLabel = 'limit'
    );

    /**
     * Render a paginated content view.
     *
     * @param string $contentId The paginated content.
     * @param array  $renderId  The id of the renderer.
     * @param string $macroFileLogicalName The optional macro file logical name.
     */
    function render(PaginatedContentInterface $content, $rendererId, $macroFileLogicalName = '');
}