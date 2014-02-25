<?php

namespace Da\PaginatorBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TestController extends ContainerAware
{
    /**
     * @Route("/")
     * @Template()
     */
    public function testAction()
    {
        $query = $this->container->get('request')->query;
        $skip = $query->get('skip', 0);
        $limit = $query->get('limit', 5);

        $paginator = $this->container->get('da_paginator.paginator');

        $paginator->defineOffsetPaginatedContent(
            'big_cities',
            'array',
            array(array(
                array('id' => 1,  'name' => 'madrid<p></p>', 'desc' => 'none'),
                array('id' => 2,  'name' => 'berlin',        'desc' => 'none'),
                array('id' => 3,  'name' => 'london',        'desc' => 'none'),
                array('id' => 4,  'name' => 'boston',        'desc' => 'none'),
                array('id' => 5,  'name' => 'chicago',       'desc' => 'none'),
                array('id' => 6,  'name' => 'new york',      'desc' => 'none'),
                array('id' => 7,  'name' => 'sidney',        'desc' => 'none'),
                array('id' => 8,  'name' => 'paris',         'desc' => 'none'),
                array('id' => 9,  'name' => 'tokyo',         'desc' => 'none'),
                array('id' => 10, 'name' => 'hong kong',     'desc' => 'none'),
                array('id' => 11, 'name' => 'pekin',         'desc' => 'none'),
                array('id' => 12, 'name' => 'bombay',        'desc' => 'none')
            )),
            $skip,
            $limit,
            'skip',
            'limit'
        );

        $paginator->definePaginatedContentView(
            'big_cities',
            'names',
            array('id' => 'Id', 'name' => 'City Name')
        );

        $paginator->setContentFieldMacro(
            'big_cities',
            'names',
            'DaPaginatorBundle:Test:macros.html.twig'
        );

        return array();
    }
}
