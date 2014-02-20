<?php

namespace Da\PaginatorBundle\View\Renderer;

use Pagerfanta\View\DefaultView;

/**
 * Twitter bootstrap renderer.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
class BasicRenderer extends AbstractRenderer
{
    /**
     * {@inheritdoc}
     */
    protected function getPaginationView()
    {
        return new DefaultView();
    }
}