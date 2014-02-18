<?php

namespace Da\PaginatorBundle\View\Renderer;

use Pagerfanta\View\TwitterBootstrapView;

/**
 * Twitter bootstrap renderer.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class TwitterBootstrapRenderer extends AbstractRenderer
{
    /**
     * {@inheritdoc}
     */
    protected function getPaginationView()
    {
        return new TwitterBootstrapView();  
    }
}