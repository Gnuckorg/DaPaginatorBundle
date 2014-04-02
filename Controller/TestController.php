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
        $paginator = $this->container->get('da_paginator.paginator');

        $cities = $paginator->defineOffsetPaginatedContent(
            array('id' => 'Id', 'name' => 'City Name'),
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
            'skip',
            'limit'
        );

        return array('cities' => $cities);
    }
}
