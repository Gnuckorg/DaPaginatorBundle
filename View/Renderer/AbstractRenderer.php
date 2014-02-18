<?php

namespace Da\PaginatorBundle\View\Renderer;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Pagerfanta\Pagerfanta;

/**
 * Abstract helper for renderer.
 *
 * @author Thomas Prelot <tprelot@gmail.com>
 */
abstract class AbstractRenderer implements RendererInterface
{
    /**
     * The templating engine.
     *
     * @var EngineInterface
     */
    private $templatingEngine;

    /**
     * Constructor.
     *
     * @param EngineInterface $templatingEngine The templating engine.
     */
    public function __construct(EngineInterface $templatingEngine)
    {
        $this->templatingEngine = $templatingEngine;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Pagerfanta $content, $routeGenerator, array $fields)
    {
        $paginationView = $this->getPaginationView();

        return $this->templatingEngine->render(
            $this->getTemplateName(),
            array_merge(
                $this->getAdditionnalTemplateData(),
                array(
                    'content' => $content,
                    'paginationView' => $paginationView,
                    'routeGenerator' => $routeGenerator,
                    'fields' => $fields
                )
            )
        );
    }

    /**
     * Get the pagination view.
     *
     * @return \Pagerfanta\View\ViewInterface The pagination view.
     */
    abstract protected function getPaginationView();

    /**
     * Get the template name.
     *
     * @return string The template name.
     */
    protected function getTemplateName()
    {
        return 'DaPaginatorBundle::base.html.twig';
    }

    /**
     * Get the additionnal template data.
     *
     * @return array The additionnal data.
     */
    protected function getAdditionnalTemplateData()
    {
        return array();
    }
}