<?php

namespace Da\PaginatorBundle\View\Renderer;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\Translation\TranslatorInterface;
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
     * The translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * Constructor.
     *
     * @param EngineInterface     $templatingEngine The templating engine.
     * @param TranslatorInterface $translator       The translator.
     */
    public function __construct(EngineInterface $templatingEngine, TranslatorInterface $translator)
    {
        $this->templatingEngine = $templatingEngine;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Pagerfanta $pager, array $content, $routeGenerator, array $fields)
    {
        $paginationView = $this->getPaginationView();

        return $this->templatingEngine->render(
            $this->getTemplateName(),
            array_merge(
                $this->getAdditionnalTemplateData(),
                array(
                    'pager' => $pager,
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