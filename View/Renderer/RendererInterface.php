<?php

namespace Da\PaginatorBundle\View\Renderer;

use Pagerfanta\Pagerfanta;

/**
 * The interface that a class should implements to be
 * used as a renderer.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
interface RendererInterface
{
    /**
     * Render a content.
     *
     * @param Pagerfanta $pager          The pager.
     * @param array      $content        The content.
     * @param callable   $routeGenerator The generator for pages' routes.
     * @param array      $fields         The displayed fields.
     * @param string     $macro          The import name of the optional macro.
     *
     * @return string The render.
     */
    function render(Pagerfanta $pager, array $content, $routeGenerator, array $fields, $macro);
}