<?php

namespace Da\PaginatorBundle\Pagination;

use Symfony\Component\DependencyInjection\ContainerInterface;

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
    public function setPagerAdapaterProvider($id, PagerAdapterProviderInterface $pagerAdapterProvider);

    /**
     * Set a renderer.
     *
     * @param string            $id       The id of the renderer.
     * @param RendererInterface $renderer The renderer.
     */
    public function setRenderer($id, RendererInterface $renderer);

    /**
     * Get a paginated content.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId     The id of the view.
     */
    public function getContent($contentId, $viewId);

    /**
     * Set a paginated content view.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId    The id of the view.
     * @param array  $content   The content.
     */
    public function setContent($contentId, $viewId, array $content);

    /**
     * Set a macro for a paginated content view.
     *
     * @param string $contentId  The id of the content.
     * @param string $viewId     The id of the view.
     * @param string $importName The name of the import of the macro.
     */
    public function setContentFieldMacro($contentId, $viewId, $importName);

    /**
     * Get a macro for a paginated content view.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId    The id of the view.
     */
    protected function getMacro($contentId, $viewId);

    /**
     * Set a the value of paginated content view row.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId    The id of the view.
     * @param array  $index     The index of the row.
     * @param array  $field     The field.
     * @param array  $value     The value.
     */
    public function setRowContentFieldValue($contentId, $viewId, $index, $field, $value);

    /**
     * Get a paginated content view.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId    The id of the view.
     */
    protected function getContentView($contentId, $viewId);

    /**
     * Define a paginated content.
     *
     * @param string  $contentId             The id of the content.
     * @param string  $pagerAdapterId        The id of the adapter.
     * @param array   $pagerAdapterArguments The arguments of the adapater.
     * @param integer $currentPage           The current page.
     * @param integer $maxPerPage            The number per page.
     * @param string  $currentPageLabel      The label of the current page query string parameter.
     * @param string  $maxPerPageLabel       The label of the number per page query string parameter.
     */
    public function definePerPagePaginatedContent($contentId, $pagerAdapterId, array $pagerAdapterArguments = array(), $currentPage, $maxPerPage, $currentPageLabel = 'page', $maxPerPageLabel = 'per_page');

    /**
     * Define a paginated content.
     *
     * @param string  $contentId             The id of the content.
     * @param string  $pagerAdapterId        The id of the adapter.
     * @param array   $pagerAdapterArguments The arguments of the adapater.
     * @param integer $offset                The number to skip.
     * @param integer $limit                 The number per page.
     * @param string  $offsetLabel           The label of the number to skip query string parameter.
     * @param string  $limitLabel            The label of the number per page query string parameter.
     */
    public function defineOffsetPaginatedContent($contentId, $pagerAdapterId, array $pagerAdapterArguments = array(), $offset, $limit, $offsetLabel = 'offset', $limitLabel = 'limit');

    /**
     * Define a paginated content view.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId    The id of the view.
     * @param array  $fields    The array of fields with propery names in key and displayed names in value.
     */
    public function definePaginatedContentView($contentId, $viewId, array $fields);

    /**
     * Count the total number of rows for a paginated content.
     *
     * @param string $contentId The id of the content.
     */
    public function countContentRows($contentId);

    /**
     * Render a paginated content view.
     *
     * @param string $contentId The id of the content.
     * @param string $viewId    The id of the view.
     * @param array  $renderId  The id of the renderer.
     */
    public function renderContentView($contentId, $viewId, $rendererId);
}