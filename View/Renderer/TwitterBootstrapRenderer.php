<?php

namespace Da\PaginatorBundle\View\Renderer;

use Pagerfanta\View\TwitterBootstrap3View;

/**
 * Twitter bootstrap renderer.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class TwitterBootstrapRenderer extends AbstractRenderer
{
    /**
     * Get the template name.
     *
     * @return string The template name.
     */
    protected function getTemplateName()
    {
        return 'DaPaginatorBundle::bootstrap.html.twig';
    }

    /**
     * {@inheritdoc}
     */
    protected function getPaginationView()
    {
        return new TwitterBootstrap3View();
    }
}